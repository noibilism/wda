<?php

namespace App\Http\Controllers;

use App\Http\Requests\Items\StoreItemRequest;
use App\Models\Item;
use App\Repository\ItemRepository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $page_title = 'Items Management';
        return view('items.index', compact('page_title'));
    }

    // API METHODS
    public function listItems(ItemRepository $itemRepository)
    {
        $data = $itemRepository->all();
        return $this->library()->responder($data, 200);
    }

    public function storeItem(StoreItemRequest $request) {
        $item =  Item::firstOrCreate($request->all());
        return $this->library()->responder($item, 201);
    }

    public function markAsSelected(Request $request, ItemRepository $itemRepository)
    {
        $markedItems = $request->items;
        $direction = $request->dir;
        // check for count
        if(count($markedItems) > 0) {
            $items = Item::whereIn('id', $markedItems)->get();
            if($direction === 'right') {
                foreach($items as $item) {
                    $item->selected = 1;
                    $item->save();
                }
            } else {
                foreach($items as $item) {
                    $item->selected = 0;
                    $item->save();
                }
            }
        }

        return $this->library()->responder($itemRepository->all(), 200);

    }

}
