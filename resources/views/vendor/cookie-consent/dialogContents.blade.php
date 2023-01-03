<!-- <div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-yellow-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="flex-1 items-center hidden md:inline">
                    <p class="ml-3 cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div> -->
<div class="js-cookie-consent cookie-consent">
    <div class="container">
      <div class="cookie-container">
        <span class="cookie-consent__message">
        {!! trans('cookie-consent::texts.message') !!}
        </span>

        <button class="js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookie-consent::texts.agree') }}
        </button>
      </div>
    </div>
</div>
