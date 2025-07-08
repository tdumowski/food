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
}
