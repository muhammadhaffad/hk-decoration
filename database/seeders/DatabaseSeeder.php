<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Decorationitem;
use App\Models\Decorationpacket;
use App\Models\District;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Regency;
use App\Models\Sessionpackage;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'username' => 'adminhk',
            'email' => 'adminhk@hkdecoration.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);
        Category::create([
            'nama' => 'Backdrop papan'
        ]);
        Category::create([
            'nama' => 'Backdrop tirai'
        ]);
        for ($i=0; $i < 10; $i++) { 
            Decorationpacket::create([
                'category_id' => 1,
                'nama' => 'Paket dekorasi '.$i,
                'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
                'harga' => 300000,
                'stok' => 10,
                'jmldisewa' => 0,
                'gambar' => 'image.png'
            ]);
        }

        Decorationitem::create([
            'nama' => 'Item dekorasi I',
            'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
            'harga' => 50000,
            'stok' => 10,
            'jmldisewa' => 0,
            'gambar' => 'image.png'
        ]);
        Decorationitem::create([
            'nama' => 'Item dekorasi II',
            'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
            'harga' => 50000,
            'stok' => 10,
            'jmldisewa' => 0,
            'gambar' => 'image.png'
        ]);
        Decorationitem::create([
            'nama' => 'Item dekorasi III',
            'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
            'harga' => 50000,
            'stok' => 10,
            'jmldisewa' => 0,
            'gambar' => 'image.png'
        ]);
        
        Sessionpackage::create([
            'nama' => 'Sesi paket I',
            'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
            'harga' => 1000000,
            'gambar' => 'image.png'
        ]);
        Sessionpackage::create([
            'nama' => 'Sesi paket II',
            'keterangan' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus quisquam nulla temporibus facere ut cum omnis voluptate facilis optio culpa necessitatibus numquam possimus, itaque eum explicabo, quaerat vel ad asperiores laboriosam aperiam corporis animi perferendis eius modi? Ipsum dolorem quos illum harum earum corporis rem optio, ratione id cum repudiandae rerum laboriosam eum! Beatae error eveniet iure, cum unde, expedita nemo soluta sit molestiae, veritatis maiores mollitia corrupti. Perspiciatis iusto et explicabo possimus neque dolorum quaerat veniam obcaecati nisi, incidunt cum at dolorem sit est tempora sed eum sequi aspernatur voluptates commodi impedit fugit. At inventore ut quos corrupti eveniet!',
            'harga' => 750000,
            'gambar' => 'image.png'
        ]);
        Regency::create([
            'nama' => 'Lamongan'
        ]);
        Regency::create([
            'nama' => 'Gresik'
        ]);
        District::create([
            'nama' => 'Pucuk'
        ]);
        District::create([
            'nama' => 'Sukodadi'
        ]);
        District::create([
            'nama' => 'Sekaran'
        ]);
        Shipping::create([
            'regency_id' => 1,
            'district_id' => 1,
            'harga' => 10000,
        ]);
        Shipping::create([
            'regency_id' => 1,
            'district_id' => 2,
            'harga' => 15000,
        ]);
        Shipping::create([
            'regency_id' => 1,
            'district_id' => 3,
            'harga' => 8000,
        ]);
        Gallery::create([
            'nama' => 'Galeri 1',
            'slug' => 'galeri-1'
        ]);
        Photo::create([
            'gallery_id' => 1,
            'foto' => 'gallery-images/slide1.jpg',
            'deskripsi' => 'ini gambar 1'
        ]);
        Photo::create([
            'gallery_id' => 1,
            'foto' => 'gallery-images/slide2.jpg',
            'deskripsi' => 'ini gambar 2'
        ]);
        Photo::create([
            'gallery_id' => 1,
            'foto' => 'gallery-images/slide3.jpg',
            'deskripsi' => 'ini gambar 3'
        ]);
    }
}
