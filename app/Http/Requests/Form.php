<?php

namespace Danshin\Comment\Http\Requests;

use Danshin\Comment\Models\CommentRequest;
use Illuminate\Foundation\Http\FormRequest as FormRequestBase;

final class Form extends FormRequestBase
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return mixed[]
     */
    public function rules()
    {
        return [
            "comment-name" => "required|string|max:50",
            "comment-email" => "nullable|email",
            "comment-message" => "required|string|max:1000"
        ];
    }

    public function getComment(): CommentRequest
    {
        $userAgent = $this->server('HTTP_USER_AGENT');

        return new CommentRequest(
            $this->server->get("REMOTE_ADDR"),
            is_array($userAgent) ? "" : $userAgent,
            new \DateTime(),
            $this->input("comment-name"),
            $this->input("comment-email"),
            $this->input("comment-message")
        );
    }
}
