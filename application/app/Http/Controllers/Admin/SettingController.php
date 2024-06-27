<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Road;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function BlockList(Request $request)
    {
        $data['blocks'] = Block::latest()->paginate(10);
        return view('admin.setting.block.list', $data);
    }
    public function roadList(Request $request)
    {
        $data['roads'] = Road::latest()->paginate(10);
        return view('admin.setting.road.list', $data);
    }
    public function addBlock()
    {
        return view('admin.setting.block.add');
    }
    public function addRoad()
    {
        return view('admin.setting.road.add');
    }
    public function storeBlock(Request $request, Block $block)
    {
        $request->validate([
            'name' => "required|unique:blocks,name,{$block->id}"
        ]);
        $item = new Block();
        $item->name = $request->name;
        $item->save();
        return redirect()->back()->with('message', 'Block Added Successfully!');
    }
    public function storeRoad(Request $request, Road $road)
    {
        $request->validate([
            'name' => "required|unique:roads,name,{$road->id}"
        ]);
        $item = new Road();
        $item->name = $request->name;
        $item->save();
        return redirect()->back()->with('message', 'Road Added Successfully!');
    }
}
