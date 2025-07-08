<?php
namespace App\Http\Controllers\Admin;

// require_once '././././vendor/autoload.php'; //'././././vendor/autoload.php';

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }

    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
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

    public function EditCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.backend.category.edit_category', compact('category'));
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
}
