<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        $pageTitle = 'Extensions';
        $extensions = Extension::orderBy('status','desc')->get();
        return view('admin.extension.index', compact('pageTitle', 'extensions'));
    }

    public function update(Request $request, $id)
    {
        $extension = Extension::findOrFail($id);
        foreach ($extension->shortcode as $key => $val) {
            $validation_rule = [$key => 'required'];
        }

        $request->validate($validation_rule);

        $shortcode = json_decode(json_encode($extension->shortcode), true);
        foreach ($shortcode as $key => $value) {
            $shortcode[$key]['value'] = $request->$key;
        }

        $extension->shortcode = $shortcode;
        $extension->save();
        $notify[] = ['success', $extension->name . ' updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        $extension = Extension::findOrFail($id);
        if ($extension->status == 1) {
            $extension->status = 0;
            $notify[] = ['success', $extension->name . ' activated successfully'];
        }else{
            $extension->status = 1;
            $notify[] = ['success', $extension->name . ' activated successfully'];
        }
        $extension->save();
        return back()->withNotify($notify);
    }
}
