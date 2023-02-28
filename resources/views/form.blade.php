<!--noindex-->

<details class="comment">
    <summary class="comment__header">
        @lang('danshin/comment::form.title')
    </summary>
    <form id="comment-form"
        class="comment__form"
        method="post"
        action="{{ route('danshin.comment', ["lang" => App::getLocale()]) }}"
        autocomplete="off"
        >
        @csrf
        <label class="comment-form-section__label_required" for="comment-form-name">
            @lang('danshin/comment::form.name')
        </label>
        <input class="comment-form-section__input" 
            type="text" 
            id="comment-form-name" 
            name="comment-name" 
            maxlength="50" 
            autocomplete="off" 
            spellcheck="true"
            required 
            />
        <small class="comment-form-section__help">@lang('danshin/comment::form.rules.name')</small>
        <label class="comment-form-section__label" for="comment-form-email">
            @lang('danshin/comment::form.email')
        </label>
        <input class="comment-form-section__input" 
            type="email" 
            id="comment-form-email"
            name="comment-email"
            autocomplete="off"
            />
        <small class="comment-form-section__help">@lang('danshin/comment::form.rules.email')</small>
        <div class="comment-form-section__label_required">
            @lang('danshin/comment::form.message')
        </div>
        <textarea class="comment-form-section__input" 
            name="comment-message" 
            spellcheck="true" 
            maxlength="1000" 
            required 
            ></textarea>
        <small class="comment-form-section__help">@lang('danshin/comment::form.rules.message')</small>
        <div class="comment-form__submit">
            <input class="comment-form-submit__button" 
                type="submit" 
                value="@lang('danshin/comment::form.submit')" />
        </div>
    </form>
</details>

<!-- message-error -->
<div id="comment-message-error" style="display: none">
    <div id="comment-message-error-header">{{ __('danshin/comment::message.title') }}</div>
    <div id="comment-message-error-content">{{ __('danshin/comment::message.error') }}</div>
</div>

<!-- log form -->
@include("danshin/comment::log")

<!--/noindex-->