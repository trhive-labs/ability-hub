<?php

namespace App\Http\Controllers;

use App\Events\DatasheetUpdatedEvent;
use App\Http\Requests\StoreDatasheetRequest;
use App\Http\Requests\UpdateDatasheetRequest;
use App\Models\Datasheet;
use App\Models\Learner;
use Illuminate\Http\Request;

class DatasheetController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDatasheetRequest $request, Learner $learner)
    {
        /** @var Datasheet $datasheet */
        $datasheet = $learner->datasheets()
            ->create($request->validated());
        $datasheet->initData();

        $message = __('New :resource created!', ['resource' => __('Datasheet')]);
        return $request->ajax() ?
            response()
                ->json(['success' => $message, 'data' => $datasheet])
            : redirect()
                ->back()
                ->with(['success' => $message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Datasheet $datasheet)
    {
        return view('datasheets.show', compact('datasheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDatasheetRequest $request, Datasheet $datasheet)
    {
        $updated_attributes = $request->validated();
        $datasheet->update($updated_attributes);

        if (array_key_exists('finalized_at', $updated_attributes) && !empty($updated_attributes['finalized_at']))
            DatasheetUpdatedEvent::dispatch($datasheet);

        $message = __("The :resource was updated!", ['resource' => __('Datasheet')]);
        return $request->ajax() ?
            response()
                ->json(['success' => $message, 'data' => $datasheet->refresh()])
            : redirect()
                ->back()
                ->with(['success' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Datasheet $datasheet)
    {
        $datasheet->delete();

        $message = __("The :resource was deleted!", ['resource' => __('Datasheet')]);
        return $request->ajax() ?
            response()
                ->json(['success' => $message, 'data' => $datasheet])
            : redirect()
                ->back()
                ->with(['success' => $message]);
    }
}
