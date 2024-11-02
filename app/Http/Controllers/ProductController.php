namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ...existing code...

    public function showBySlug($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return response()->json($product);
    }
}
