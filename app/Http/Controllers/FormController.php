<?php

namespace Danshin\Comment\Http\Controllers;

use Illuminate\Routing\Controller as Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Danshin\Comment\Http\Requests\Form as Request;
use Danshin\Comment\Repository\Repository;

final class FormController extends Controller
{
    public function __invoke(Request $request, Repository $repository, string $lang): JsonResponse
    {
        App::setLocale($lang);

        $repository->add($request->getComment());

        return response()->json([
            'header' => __('danshin/comment::message.title'),
            'content' => __('danshin/comment::message.info')
        ]);
    }
}
