<?php

use App\Http\Controllers\Admin\ConfirmationController;
use App\Http\Controllers\Admin\DecorationItemController as AdminDecorationItemController;
use App\Http\Controllers\Admin\DecorationPacketController as AdminDecorationPacketController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\SessionPackageController as AdminSessionPackageController;
use App\Http\Controllers\Admin\UnpaidController;
use App\Http\Controllers\Admin\ShippingController as AdminShippingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DecorationController;
use App\Http\Controllers\DecorationitemController;
use App\Http\Controllers\DecorationpacketController;
use App\Http\Controllers\GalleryController as ControllersGalleryController;
use App\Http\Controllers\HomepageController as ControllersHomepageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ParternController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReorderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\TripayCallbackController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ControllersHomepageController::class, 'view'])->name('home');

Route::get('/shipping', [ShippingController::class, 'view'])->name('shipping');

Route::get('/decoration', [DecorationController::class, 'view'])->name('decoration');

Route::get('/decoration/packet/getdata', [AdminDecorationPacketController::class, 'detailDecor']);
Route::get('/decoration/item/getdata', [AdminDecorationItemController::class, 'detailDecor']);
Route::get('/session-package/getdata', [AdminSessionPackageController::class, 'detailSession']);

Route::get('/decoration/packet/{id}', [DecorationpacketController::class, 'show'])->name('decoration.packet.detail');
Route::post('/decoration/packet/{id}', [DecorationpacketController::class, 'addReview'])->name('decoration.packet.add-review');
Route::post('/decoration/packet/{id}/addtocart', [DecorationpacketController::class, 'addToCart'])->name('decoration.packet.add-cart')->middleware('role:user');

Route::get('/decoration/item/{id}', [DecorationitemController::class, 'show'])->name('decoration.item.detail');
Route::post('/decoration/item/{id}', [DecorationitemController::class, 'addReview'])->name('decoration.item.add-review');
Route::post('/decoration/item/{id}/addtocart', [DecorationitemController::class, 'addToCart'])->name('decoration.item.add-cart')->middleware('role:user');

Route::post('/decoration/addtocart/{id}', [DecorationController::class, 'addToCart'])->name('decoration.addtocart')->middleware('role:user');

Route::get('/partern', [ParternController::class, 'view'])->name('partern');
Route::get('/partern/{id}', [ParternController::class, 'show'])->name('partern.detail');
Route::post('/partern/{id}', [ParternController::class, 'addReview'])->name('partern.add-review');
Route::post('/partern/addtocart/{id}', [ParternController::class, 'addToCart'])->name('partern.addtocart')->middleware('role:user');

Route::get('/gallery', [ControllersGalleryController::class, 'view'])->name('galery');
Route::get('/gallery/{slug}', [ControllersGalleryController::class, 'gallery'])->name('galery.detail');

Route::get('/cart', [CartController::class, 'view'])->name('cart')->middleware('role:user');
Route::get('/cart/incQty/{id}', [CartController::class, 'increaseQty'])->name('cart.incQty')->middleware('role:user');
Route::get('/cart/decQty/{id}', [CartController::class, 'decreaseQty'])->name('cart.decQty')->middleware('role:user');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove')->middleware('role:user');

Route::get('/checkout', [CheckoutController::class, 'view'])->name('checkout')->middleware('role:user');
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.save')->middleware('role:user');
Route::post('/checkout/change', [CheckoutController::class, 'checkoutUpdate'])->name('checkout.change')->middleware('role:user');

Route::get('/myorder/{code}', [OrderController::class, 'show'])->name('myorder.detail')->middleware('role:user');
Route::get('/myorder', [OrderController::class, 'index'])->name('myorder')->middleware('role:user');
Route::post('/myorder', [OrderController::class, 'order'])->name('myorder.order')->middleware('role:user');

Route::get('/reorder/{code}', [ReorderController::class, 'index'])->name('reorder')->middleware('role:user');

Route::post('/invoice', [InvoiceController::class, 'view'])->name('invoice')->middleware('role:user,superadmin,admin');
Route::post('/receipt', [ReceiptController::class, 'view'])->name('receipt')->middleware('role:user,superadmin,admin');

Route::get('/chat', [ChatController::class, 'index'])->name('chat')->middleware('role:user');
Route::post('/chat/send', [ChatController::class, 'store'])->name('chat.send')->middleware('role:user');

Route::post('/tripay/callback', [TripayCallbackController::class, 'handle']);

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [UserController::class, 'login'])->name('user.login');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/profile', [UserController::class, 'profile'])->name('user.profile')->middleware('role:user');
Route::get('/edit-profile', function () {
    return view('edit-profile');
})->middleware('role:user');
Route::post('/edit-profile', [UserController::class, 'editprofile'])->name('user.edit-profile')->middleware('role:user');


Route::get('admin/login', function () {
    return view('admin.login');
})->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login']);

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->middleware('role:superadmin,admin')->group(function () {
    // new admin view
    Route::get('/dashboard', [DashboardController::class, 'view'])->name('admin.dashboard');
    Route::get('/dashboard/charts/monthly/incomes', [DashboardController::class, 'income'])->name('admin.dashboard.charts.monthly-incomes');
    Route::get('/dashboard/charts/monthly/orders', [DashboardController::class, 'order'])->name('admin.dashboard.charts.monthly-orders');

    Route::get('/order', [ConfirmationController::class, 'detailOrder'])->name('admin.detail-order');

    Route::get('/return', [ReturnController::class, 'view'])->name('admin.return');
    Route::post('/return/confirm', [ReturnController::class, 'confirm'])->name('admin.return.confirm');

    Route::get('/orders', [ConfirmationController::class, 'index'])->name('admin.confirmation');
    Route::post('/confirmation/confirm', [ConfirmationController::class, 'confirm'])->name('admin.confirmation.confirm');
    Route::post('/confirmation/fail', [ConfirmationController::class, 'fail'])->name('admin.confirmation.fail');
    Route::post('/confirmation/destroy', [ConfirmationController::class, 'destroy'])->name('admin.confirmation.destroy');

    Route::get('/unpaid', [UnpaidController::class, 'view'])->name('admin.unpaid');
    Route::post('/unpaid/destroy', [UnpaidController::class, 'destroy'])->name('admin.unpaid.destroy');

    Route::get('/bank', [BankController::class, 'view'])->name('admin.bank');
    Route::post('/bank/update', [BankController::class, 'update'])->name('admin.bank.update');
    Route::post('/bank/add', [BankController::class, 'store'])->name('admin.bank.store');
    Route::post('/bank/delete', [BankController::class, 'destroy'])->name('admin.bank.destroy');

    Route::get('/decoration-packet', [AdminDecorationPacketController::class, 'view'])->name('admin.decoration-packet');
    Route::post('/decoration-packet/update', [AdminDecorationPacketController::class, 'update'])->name('admin.decoration-packet.update');
    Route::post('/decoration-packet/store', [AdminDecorationPacketController::class, 'store'])->name('admin.decoration-packet.store');
    Route::post('/decoration-packet/destroy', [AdminDecorationPacketController::class, 'destroy'])->name('admin.decoration-packet.delete');

    Route::get('/decoration-item', [AdminDecorationItemController::class, 'view'])->name('admin.decoration-item');
    Route::post('/decoration-item/update', [AdminDecorationItemController::class, 'update'])->name('admin.decoration-item.update');
    Route::post('/decoration-item/store', [AdminDecorationItemController::class, 'store'])->name('admin.decoration-item.store');
    Route::post('/decoration-item/destroy', [AdminDecorationItemController::class, 'destroy'])->name('admin.decoration-item.destroy');

    Route::get('/session-package', [AdminSessionPackageController::class, 'view'])->name('admin.session-package');
    Route::post('/session-package/update', [AdminSessionPackageController::class, 'update'])->name('admin.session-package.update');
    Route::post('/session-package/store', [AdminSessionPackageController::class, 'store'])->name('admin.session-package.store');
    Route::post('/session-package/destroy', [AdminSessionPackageController::class, 'destroy'])->name('admin.session-package.destroy');

    Route::get('/employee', [AdminController::class, 'view'])->name('admin.employee')->middleware('role:superadmin');
    Route::post('/employee/add', [AdminController::class, 'addAdmin'])->middleware('role:superadmin');
    Route::post('/employee/update', [AdminController::class, 'update'])->middleware('role:superadmin');
    Route::post('/employee/delete', [AdminController::class, 'destroy'])->middleware('role:superadmin');

    Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');
    Route::post('/customer/update', [CustomerController::class, 'update'])->name('admin.customer.update');
    Route::post('/customer/inactive', [CustomerController::class, 'inactive'])->name('admin.customer.inactive');
    Route::post('/customer/active', [CustomerController::class, 'active'])->name('admin.customer.active');

    Route::get('/category', function () {
        return view('admin.category');
    })->name('admin.category');
    Route::get('/shipping', [AdminShippingController::class, 'view'])->name('admin.shipping');
    Route::post('/shipping/add-regency', [AdminShippingController::class, 'add_regency']);
    Route::post('/shipping/add-district', [AdminShippingController::class, 'add_district']);
    Route::post('/shipping/add-shipping', [AdminShippingController::class, 'add_shipping']);
    Route::post('/shipping/update-regency', [AdminShippingController::class, 'update_regency']);
    Route::post('/shipping/update-district', [AdminShippingController::class, 'update_district']);
    Route::post('/shipping/update-shipping', [AdminShippingController::class, 'update_shipping']);
    Route::post('/shipping/delete-regency', [AdminShippingController::class, 'delete_regency']);
    Route::post('/shipping/delete-district', [AdminShippingController::class, 'delete_district']);
    Route::post('/shipping/delete-shipping', [AdminShippingController::class, 'delete_shipping']);

    Route::get('/report/monthly', [ReportController::class, 'view'])->name('admin.report.monthly');
    Route::get('/report/monthly/export', [ReportController::class, 'export']);

    Route::get('/gallery', [GalleryController::class, 'view'])->name('admin.gallery');
    Route::post('/gallery', [GalleryController::class, 'store']);
    Route::post('/gallery/delete', [GalleryController::class, 'delete']);
    Route::get('/gallery/{slug}', [GalleryController::class, 'update_view'])->name('admin.gallery-view');
    Route::post('/gallery/{slug}', [GalleryController::class, 'store_image']);
    Route::post('/gallery/{slug}/update', [GalleryController::class, 'update_image']);
    Route::post('/gallery/{slug}/delete', [GalleryController::class, 'delete_image']);

    Route::get('/home-page', [HomepageController::class, 'view'])->name('admin.home-page');
    Route::post('/home-page/add', [HomepageController::class, 'store'])->name('admin.home-page.add');
    Route::post('/home-page/update', [HomepageController::class, 'update'])->name('admin.home-page.update');
    Route::post('/home-page/destroy', [HomepageController::class, 'destroy'])->name('admin.home-page.delete');

    Route::get('/chat', [AdminChatController::class, 'index'])->name('admin.chat');
    Route::get('/chat/{id}', [AdminChatController::class, 'index'])->name('admin.chat.to');
    Route::post('/chat/{id}/send', [AdminChatController::class, 'store'])->name('admin.chat.send');

});
