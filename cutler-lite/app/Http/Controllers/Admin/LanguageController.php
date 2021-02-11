<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\LanguageSetting;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->page['title'] = 'Policies';
        $this->page['sub_title'] = '';
    }

    public function index()
    {
        $languages = Language::all();

        return view('admin.language.index', compact('languages'))->with('page', $this->page);
    }

    public function statusChange($id, $status)
    {
        $langCheck = Language::find($id);
        if ($langCheck) {
            if ($status == 0) {
                $activeLanguages = Language::where('status', 1)->get();
                if ($activeLanguages->count() > 1) {
                    $langCheck->status = $status;
                    $langCheck->save();
                } else {
                    session_error(trans('translation.language.passive-error-min-1-language'));
                }
            } else {
                $langCheck->status = $status;
                $langCheck->save();
            }
        }

        return redirect()->route('language.index');
    }

    public function translations()
    {
        $languages = Language::all();
        $translations = LanguageSetting::all();

        return view('admin.language.translations', compact('languages', 'translations'))->with('page', $this->page);
    }

    public function translationsTable()
    {
        $languages = Language::all();
        $translations = LanguageSetting::all();

        echo '<table border="1">';
        if($translations->count() > 0){
            foreach($translations as $temp){
                echo '<tr>';
                    echo '<td>'.$temp->id.'</td>';
                    echo '<td>'.$temp->key.'</td>';
                    echo '<td>'.$temp->en.'</td>';
                echo '</tr>';
            }
        }
        echo '</table>';

        exit;
    }

    public function translationModal(Request $request)
    {
        $id = $request->id;
        $languages = Language::all();
        $translation = LanguageSetting::find($id);

        return view('admin.language.translationModal', compact('languages', 'translation'))->with('page', $this->page);
    }

    public function translationSave(Request $request)
    {
        $id = $request->id;
        $languages = Language::all();
        $translation = LanguageSetting::find($id);

        if ($translation) {
            if ($languages->count() > 0) {
                foreach ($languages as $language) {
                    $code = $language->code;
                    if ($request->$code != '') {
                        $translation->$code = $request->$code;
                    }
                }
            }

            $status = $translation->save();

            if ($status) {
                $json['status'] = 1;
            } else {
                $json['status'] = 0;
            }
        } else {
            $json['status'] = 0;
        }

        return response()->json($json);
    }
}
