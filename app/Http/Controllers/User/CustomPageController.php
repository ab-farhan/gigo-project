<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\CustomPage\Page;
use App\Models\User\CustomPage\PageContent;
use App\Models\User\Language;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class CustomPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $information['langs'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['language'] = $information['langs']->where('code', $request->language)->first();

        // then, get the custom pages of that language from db
        $information['pages'] = DB::table('user_pages')
            ->join('user_page_contents', 'user_pages.id', '=', 'user_page_contents.page_id')
            ->where('user_page_contents.language_id', '=', $information['language']->id)
            ->orderByDesc('user_pages.id')
            ->get();

        return view('user.custom-page.index', $information);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        // get all the languages from db
        $information['languages'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['defaultLang'] = $information['languages']->where('is_default', 1)->first();
        return view('user.custom-page.create', $information);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return
     */
    public function store(Request $request)
    {
        $rules = ['status' => 'required'];
        $languages = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $messages = [];

        foreach ($languages as $language) {
            $slug = slug_create($request[$language->code . '_title']);
            $rules[$language->code . '_title'] = [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($slug, $language) {
                    $pcs = PageContent::where('language_id', $language->id)->where('user_id', Auth::guard('web')->user()->id)->get();
                    foreach ($pcs as $key => $pc) {
                        if (strtolower($slug) == strtolower($pc->slug)) {
                            $fail('The title field must be unique for ' . $language->name . ' language.');
                        }
                    }
                }
            ];
            $rules[$language->code . '_content'] = 'min:15';

            $messages[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language.';

            $messages[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

            $messages[$language->code . '_title.unique'] = 'The title field must be unique for ' . $language->name . ' language.';

            $messages[$language->code . '_content.min'] = 'The content field at least have 15 characters for ' . $language->name . ' language.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $page = new Page();
        $page->user_id = Auth::guard('web')->user()->id;
        $page->status = $request->status;
        $page->save();

        foreach ($languages as $language) {
            $pageContent = new PageContent();
            $pageContent->language_id = $language->id;
            $pageContent->user_id = Auth::guard('web')->user()->id;
            $pageContent->page_id = $page->id;
            $pageContent->title = $request[$language->code . '_title'];
            $pageContent->slug = make_slug($request[$language->code . '_title']);
            $pageContent->content = Purifier::clean($request[$language->code . '_content']);
            $pageContent->meta_keywords = $request[$language->code . '_meta_keywords'];
            $pageContent->meta_description = $request[$language->code . '_meta_description'];
            $pageContent->save();
        }

        $request->session()->flash('success', 'New page added successfully!');
        return "success";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $information['languages'] = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();
        $information['defaultLang'] = $information['languages']->where('is_default', 1)->first();
        $information['page'] = Page::query()->where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
        return view('user.custom-page.edit', $information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function update(Request $request, int $id)
    {
        $rules = ['status' => 'required'];

        $languages = Language::query()->where('user_id', Auth::guard('web')->user()->id)->get();

        $messages = [];

        foreach ($languages as $language) {
            $slug = slug_create($request[$language->code . '_title']);
            $rules[$language->code . '_title'] = [
              'required',
              'max:255',
              function ($attribute, $value, $fail) use ($slug, $id, $language) {
                  $pcs = PageContent::where('page_id', '<>', $id)->where('language_id', $language->id)->where('user_id', Auth::guard('web')->user()->id)->get();
                  foreach ($pcs as $key => $pc) {
                      if (strtolower($slug) == strtolower($pc->slug)) {
                          $fail('The title field must be unique for ' . $language->name . ' language.');
                      }
                  }
              }
            ];

            $rules[$language->code . '_content'] = 'min:15';

            $messages[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language.';

            $messages[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

            $messages[$language->code . '_title.unique'] = 'The title field must be unique for ' . $language->name . ' language.';

            $messages[$language->code . '_content.min'] = 'The content field atleast have 15 characters for ' . $language->name . ' language.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $page = Page::query()->where('user_id', Auth::guard('web')->user()->id)->findOrFail($id);
        $page->update(['status' => $request->status]);

        foreach ($languages as $language) {
            PageContent::query()->updateOrCreate([
                'page_id' => $id,
                'user_id' => Auth::guard('web')->user()->id,
                'language_id' => $language->id
            ],[
                'title' => $request[$language->code . '_title'],
                'slug' => make_slug($request[$language->code . '_title']),
                'content' => Purifier::clean($request[$language->code . '_content']),
                'user_id' => Auth::guard('web')->user()->id,
                'language_id' => $language->id,
                'meta_keywords' => $request[$language->code . '_meta_keywords'],
                'meta_description' => $request[$language->code . '_meta_description']
            ]);
        }

        $request->session()->flash('success', 'Page updated successfully!');
        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Page::query()->where('user_id', Auth::guard('web')->user()->id)->findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Page deleted successfully!');
    }

    /**
     * Remove the selected or all resources from storage.
     *
     * @param Request $request
     * @return string
     */
    public function bulkDestroy(Request $request): string
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            Page::query()->where('user_id', Auth::guard('web')->user()->id)->findOrFail($id)->delete();
        }
        $request->session()->flash('success', 'Pages deleted successfully!');
        return "success";
    }
}
