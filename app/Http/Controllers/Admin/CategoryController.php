<?php
namespace App\Http\Controllers\Admin;

// require_once '././././vendor/autoload.php'; //'././././vendor/autoload.php';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\City;

class CategoryController extends Controller
{
    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
    }

    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('categories'));
    }

    public function AllCity()
    {
        $cities = City::latest()->get();
        return view('admin.backend.city.all_city', compact('cities'));
    }

    public function DeleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category) {
            if ($category->image != 'upload/no_image.jpg') {
                unlink(public_path($category->image));
            }
            $category->delete();
            
            $notification = array(
                "message" => "Category deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.category')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Category not found", 
                "alert-type" => "error"
            );
            return redirect()->route('all.category')->with($notification);
        }
    }

    public function DeleteCity($id)
    {
        $city = City::findOrFail($id);
        
        if ($city) {
            $city->delete();
            
            $notification = array(
                "message" => "City deleted successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.city')->with($notification);
        }
        else {
            $notification = array(
                "message" => "City not found", 
                "alert-type" => "error"
            );
            return redirect()->route('all.city')->with($notification);
        }
    }

    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }

    public function EditCity($id)
    {
        $city = City::findOrFail($id);
        return response()->json($city);
    }
    
    public function StoreCategory(Request $request)
    {        
        if($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $save_url = 'upload/category/'.$imageName;
            $img->resize(300, 300)->save(public_path($save_url));
            
            $category = new Category();
            $category->name = $request->name;
            $category->image = $save_url;
            $category->save();
        }
        else {
            $category = new Category();
            $category->name = $request->name;
            $category->image = 'upload/no_image.jpg';
            $category->save();
        }
        
        $notification = array(
            "message" => "Category added successfully", 
            "alert-type" => "success"
        );
        return redirect()->route('all.category')->with($notification);
    }
    
    public function StoreCity(Request $request)
    {        
            $city = new City();
            $city->name = $request->name;
            $city->slug = strtolower(str_replace(' ', '-', $request->name));
            $city->save();
        
        $notification = array(
            "message" => "City added successfully", 
            "alert-type" => "success"
        );
        // return redirect()->route('all.city')->with($notification);
        return redirect()->back()->with($notification);
    }

    public function UpdateCategory(Request $request)
    {
        $category = Category::findOrFail($request->id);
        
        if($category) {
            if($request->file('image')) {
                $image = $request->file('image');
                $manager = new ImageManager(new Driver());
                $imageName = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $img = $manager->read($image);
                $save_url = 'upload/category/'.$imageName;
                $img->resize(300, 300)->save(public_path($save_url));
                
                // Delete old image
                if ($category->image != 'upload/no_image.jpg') {
                    unlink(public_path($category->image));
                }
                
                $category->image = $save_url;
            }

            $category->name = $request->name;
            $category->save();
            
            $notification = array(
                "message" => "Category updated successfully", 
                "alert-type" => "success"
            );
            return redirect()->route('all.category')->with($notification);
        }
        else {
            $notification = array(
                "message" => "Category not found", 
                "alert-type" => "error"
            );
            return redirect()->route('all.category')->with($notification);
        }
    }
    
    public function UpdateCity(Request $request)
    {
        echo $request->city_id;
        $city = City::findOrFail($request->city_id);

        if($city) {
            $city->name = $request->name;
            $city->slug = strtolower(str_replace(' ', '-', $request->name));
            $city->save();
            
            $notification = array(
                "message" => "City updated successfully", 
                "alert-type" => "success"
            );
            return redirect()->back()->with($notification);
        }

        $notification = array(
            "message" => "City not found", 
            "alert-type" => "error"
        );
        return redirect()->back()->with($notification);
    }
}
