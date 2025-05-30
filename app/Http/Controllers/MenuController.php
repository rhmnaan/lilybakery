<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan produk dan header berdasarkan kategori yang dipilih di URL.
     * 
     * @param string $category
     * @return \Illuminate\View\View
     */
    public function showCategory($category)
    {
        // Data produk per kategori
        $products = [
            'bread' => [
                ['name' => 'Sourdough Bread', 'price' => 50000, 'rating' => 4, 'image_url' => '/images/menu/bread.jpg'],
                ['name' => 'Whole Wheat Bread', 'price' => 45000, 'rating' => 5, 'image_url' => '/images/menu/bread.jpg'],
            ],
            'cake' => [
                ['name' => 'Chocolate Cake', 'price' => 120000, 'rating' => 5, 'image_url' => '/images/menu/cake.jpg'],
                ['name' => 'Vanilla Cake', 'price' => 110000, 'rating' => 4, 'image_url' => '/images/menu/cake.jpg'],
            ],
            'cookies' => [
                ['name' => 'Chocolate Chip Cookie', 'price' => 25000, 'rating' => 4, 'image_url' => '/images/menu/cookies.jpg'],
                ['name' => 'Oatmeal Cookie', 'price' => 20000, 'rating' => 3, 'image_url' => '/images/menu/cookies.jpg'],
            ],
            'donat' => [
                ['name' => 'Glazed Donut', 'price' => 15000, 'rating' => 3, 'image_url' => '/images/menu/donat.jpg'],
                ['name' => 'Chocolate Donut', 'price' => 18000, 'rating' => 4, 'image_url' => '/images/menu/donat.jpg'],
            ],
            'macaroon' => [
                ['name' => 'Vanilla Macaroon', 'price' => 30000, 'rating' => 5, 'image_url' => '/images/menu/Macaroon.jpg'],
                ['name' => 'Raspberry Macaroon', 'price' => 35000, 'rating' => 5, 'image_url' => '/images/menu/Macaroon.jpg'],
            ],
        ];

        // Data header (judul dan subtitle) per kategori
        $headers = [
            'bread' => [
                'title' => 'Delicious Bread Selection',
                'subtitle' => 'Freshly baked bread to warm your heart'
            ],
            'cake' => [
                'title' => 'Sweet and Moist Cakes',
                'subtitle' => 'Perfect cakes for every celebration'
            ],
            'cookies' => [
                'title' => 'Crunchy Cookies',
                'subtitle' => 'Sweet snacks for your coffee break'
            ],
            'donat' => [
                'title' => 'Delightful Donuts',
                'subtitle' => 'Soft and fluffy donuts with various toppings'
            ],
            'macaroon' => [
                'title' => 'Colorful Macaroons',
                'subtitle' => 'Taste the delicate French treats'
            ],
        ];

        // Validasi kategori
        if (!array_key_exists($category, $products)) {
            abort(404); // Halaman 404 jika kategori tidak ditemukan
        }

        // Kirim data ke view
        return view('category-menu', [
            'category' => $category,
            'products' => $products[$category],
            'header' => $headers[$category] ?? ['title' => 'Menu', 'subtitle' => 'Our delicious menu'],
        ]);
    }

    /**
     * Menampilkan detail produk berdasarkan kategori dan nama produk.
     * 
     * @param string $category
     * @param string $productName (slug, misal: sourdough-bread)
     * @return \Illuminate\View\View
     */
    public function showProductDetail($category, $productName)
    {
        // Sama data produk seperti di showCategory
        $products = [
            'bread' => [
                ['name' => 'Sourdough Bread', 'price' => 50000, 'rating' => 4, 'image_url' => '/images/menu/bread.jpg', 'description' => 'Delicious sourdough bread with crispy crust and soft inside.'],
                ['name' => 'Whole Wheat Bread', 'price' => 45000, 'rating' => 5, 'image_url' => '/images/menu/bread.jpg', 'description' => 'Healthy whole wheat bread rich in fiber and nutrients.'],
            ],
            'cake' => [
                ['name' => 'Chocolate Cake', 'price' => 120000, 'rating' => 5, 'image_url' => '/images/menu/cake.jpg', 'description' => 'Rich and moist chocolate cake perfect for celebrations.'],
                ['name' => 'Vanilla Cake', 'price' => 110000, 'rating' => 4, 'image_url' => '/images/menu/cake.jpg', 'description' => 'Classic vanilla cake with creamy frosting.'],
            ],
            'cookies' => [
                ['name' => 'Chocolate Chip Cookie', 'price' => 25000, 'rating' => 4, 'image_url' => '/images/menu/cookies.jpg', 'description' => 'Crunchy cookies loaded with chocolate chips.'],
                ['name' => 'Oatmeal Cookie', 'price' => 20000, 'rating' => 3, 'image_url' => '/images/menu/cookies.jpg', 'description' => 'Soft oatmeal cookies with a hint of cinnamon.'],
            ],
            'donat' => [
                ['name' => 'Glazed Donut', 'price' => 15000, 'rating' => 3, 'image_url' => '/images/menu/donat.jpg', 'description' => 'Sweet glazed donut with soft texture.'],
                ['name' => 'Chocolate Donut', 'price' => 18000, 'rating' => 4, 'image_url' => '/images/menu/donat.jpg', 'description' => 'Donut topped with rich chocolate glaze.'],
            ],
            'macaroon' => [
                ['name' => 'Vanilla Macaroon', 'price' => 30000, 'rating' => 5, 'image_url' => '/images/menu/Macaroon.jpg', 'description' => 'Delicate vanilla flavored French macaroon.'],
                ['name' => 'Raspberry Macaroon', 'price' => 35000, 'rating' => 5, 'image_url' => '/images/menu/Macaroon.jpg', 'description' => 'Tangy raspberry macaroon with smooth filling.'],
            ],
        ];

        // Validasi kategori
        if (!array_key_exists($category, $products)) {
            abort(404);
        }

        // Cari produk sesuai slug $productName
        $slugToName = function ($name) {
            return strtolower(str_replace(' ', '-', $name));
        };

        $product = null;
        foreach ($products[$category] as $item) {
            if ($slugToName($item['name']) === $productName) {
                $product = $item;
                break;
            }
        }

        if (!$product) {
            abort(404);
        }

        // Kirim ke view product-detail
        return view('product-detail', [
            'category' => $category,
            'product' => $product,
        ]);
    }
}
