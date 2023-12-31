<?php

use App\Livewire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;


Route::get('/custom-livewire', function () {
    return view('custom-livewire');
});

Route::get('/', function () {
    return view('livewire');
});

Route::post('/livewire', function (Request $request) {
    $component = (new Livewire())->fromSnapshot($request->snapshot);

    if ($method = $request->callMethod) {
        (new Livewire())->callMethod($component, $method);
    }

    if ([$property, $value] = $request->updateProperty) {
        (new Livewire())->updateProperty($component, $property, $value);
    }

    [$html, $snapshot] = (new Livewire())->toSnapshot($component);

    return [
        'html' => $html,
        'snapshot' => $snapshot
    ];
});

Blade::directive('customLivewire', function ($expression) {

    return "<?php echo (new \App\Livewire())->initialRender({$expression}) ?>";
});
