<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\Helpers\StracePath;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $productRepo;
    private $categoryRepo;
    private $categoryRecursive;
    private $stracePath;

    public function __construct(
        IProductRepository  $IProductRepository,
        StracePath          $stracePath,
        ICategoryRepository $ICategoryRepository,
        CategoryRecursive   $categoryRecursive
    )
    {
        $this->productRepo = $IProductRepository;
        $this->stracePath = $stracePath;
        $this->categoryRepo = $ICategoryRepository;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index($categorySlug)
    {
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse, 'menuSidebar' => $menuSidebar]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse', 'menuSidebar');
        [$categorySlug => $categoryIds] = $this->categoryRecursive->getIdBySlug($categorySlug);
        $data = $this->productRepo->getAllByCateID($categoryIds);
        if (request()->exists('gia-ban') || request()->exists('sap-xep')) {
            if (request()->exists('gia-ban')) {
                switch (request('gia-ban')) {
                    case Str::slug('Dưới 10 triệu'):
                        $data = $data->where('price', '<', '10000000');
                        break;
                    case Str::slug('10 - 20 triệu'):
                        $data = $data->where('price', '>=', '10000000')->where('price', '<', '20000000');
                        break;
                    case Str::slug('20 - 30 triệu'):
                        $data = $data->where('price', '>=', '20000000')->where('price', '<', '30000000');
                        break;
                    case Str::slug('trên 40 triệu'):
                        $data = $data->where('price', '>=', '20000000')->where('price', '>=', '40000000');
                        break;
                }
            }
            if (request()->exists('sap-xep')) {
                $data = $data->sortBy('price');
                if (request('sap-xep') == Str::slug('Giá cao đến thấp')) $data = $data->reverse();
            }
        }
        $category = $this->categoryRepo->findBySlug($categorySlug);
        $products = $this->productRepo->pagination($data, 15);
        return
            view('client.products.index',
                compact(
                    'megaMenuHeader',
                    'menuSidebar',
                    'menuResponse',
                    'products',
                    'category',
                )
            );
    }


    public function detailItem($slug)
    {
        [
            'megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse
        ] = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $product = $this->productRepo->getItemBySlug($slug);
        $images = $product->images;
        $stracePath = $this->stracePath->stracePath($product->category_id, $product->name);
        $correlativeItems = $product->tags()->first()->products->filter(function ($value, $key) use ($product) {
            return $value->id != $product->id;
        });
        $correlativeItems = $correlativeItems->take(2);
        return
            view('client.products.detail',
                compact(
                    'megaMenuHeader',
                    'product',
                    'stracePath',
                    'images',
                    'correlativeItems',
                    'menuResponse',
                )
            );
    }
}
