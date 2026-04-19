<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@pos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Cashier
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@pos.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        // Settings
        Setting::set('store_name', 'Antigravity POS');
        Setting::set('store_address', 'Jl. Contoh No. 123, Jakarta');
        Setting::set('store_phone', '021-1234567');
        Setting::set('tax_enabled', '1');
        Setting::set('tax_percentage', '11');

        // Categories
        $categories = [
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Produk makanan'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Produk minuman'],
            ['name' => 'Snack', 'slug' => 'snack', 'description' => 'Makanan ringan'],
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Barang elektronik'],
            ['name' => 'Kebutuhan Rumah', 'slug' => 'kebutuhan-rumah', 'description' => 'Kebutuhan rumah tangga'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Products
        $products = [
            ['category_id' => 1, 'name' => 'Nasi Goreng', 'sku' => 'MKN-001', 'price' => 25000, 'stock' => 50, 'description' => 'Nasi goreng spesial'],
            ['category_id' => 1, 'name' => 'Mie Ayam', 'sku' => 'MKN-002', 'price' => 20000, 'stock' => 40, 'description' => 'Mie ayam bakso'],
            ['category_id' => 1, 'name' => 'Ayam Geprek', 'sku' => 'MKN-003', 'price' => 22000, 'stock' => 35, 'description' => 'Ayam geprek sambal'],
            ['category_id' => 2, 'name' => 'Es Teh Manis', 'sku' => 'MNM-001', 'price' => 8000, 'stock' => 100, 'description' => 'Teh manis dingin'],
            ['category_id' => 2, 'name' => 'Kopi Susu', 'sku' => 'MNM-002', 'price' => 15000, 'stock' => 60, 'description' => 'Kopi susu gula aren'],
            ['category_id' => 2, 'name' => 'Jus Jeruk', 'sku' => 'MNM-003', 'price' => 12000, 'stock' => 45, 'description' => 'Jus jeruk segar'],
            ['category_id' => 3, 'name' => 'Keripik Singkong', 'sku' => 'SNK-001', 'price' => 10000, 'stock' => 80, 'description' => 'Keripik singkong renyah'],
            ['category_id' => 3, 'name' => 'Coklat Bar', 'sku' => 'SNK-002', 'price' => 15000, 'stock' => 55, 'description' => 'Coklat batangan premium'],
            ['category_id' => 4, 'name' => 'Kabel USB-C', 'sku' => 'ELK-001', 'price' => 35000, 'stock' => 25, 'description' => 'Kabel USB Type-C'],
            ['category_id' => 4, 'name' => 'Power Bank', 'sku' => 'ELK-002', 'price' => 150000, 'stock' => 15, 'description' => 'Power bank 10000mAh'],
            ['category_id' => 5, 'name' => 'Sabun Cuci', 'sku' => 'RMH-001', 'price' => 18000, 'stock' => 70, 'description' => 'Sabun cuci cair 1L'],
            ['category_id' => 5, 'name' => 'Tisu Wajah', 'sku' => 'RMH-002', 'price' => 12000, 'stock' => 3, 'low_stock_threshold' => 5, 'description' => 'Tisu wajah lembut'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Customers
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567890', 'email' => 'budi@email.com', 'address' => 'Jl. Merdeka No. 1'],
            ['name' => 'Siti Nurhaliza', 'phone' => '082345678901', 'email' => 'siti@email.com', 'address' => 'Jl. Sudirman No. 10'],
            ['name' => 'Ahmad Dahlan', 'phone' => '083456789012', 'email' => 'ahmad@email.com', 'address' => 'Jl. Diponegoro No. 5'],
        ];

        foreach ($customers as $cust) {
            Customer::create($cust);
        }
    }
}
