<!DOCTYPE html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{session()->get('locale') === 'en' ? 'Forgot password | PupilPay' : 'Elfelejtett Jelszó | PupilPay'}}</title>
    <link rel="stylesheet" href="<?php echo asset('css/app.css'); ?>" type="text/css">
</head>

<body class="h-full">
<div class="absolute top-0 right-0 mt-3 mr-4">
    <label for="language" class="sr-only">Country</label>
    <select
        required
        id="language"
        name="language"
        autocomplete="language"
        class="relative block w-full appearance-none rounded-md border border-gray-300 py-2 pr-8 pl-3 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"

        onchange="setLanguage(this.value)"
    >
        <option value="en" {{ (old('language') ?? session()->get('locale')) === 'en' ? 'selected' : '' }}>{{__('english')}}</option>
        <option value="hu" {{ (old('language') ?? session()->get('locale')) === 'hu' ? 'selected' : '' }}>{{__('hungary')}}</option>
    </select>
</div>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-16 w-auto" src="<?php echo asset('img/pupilpay-black-color.svg') ?>"
                    alt="PupilPay" />
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">{{session()->get('locale') === 'en' ? 'Request password a reset' : 'Elfejeltett jelszó'}}</h2>
            </div>
            @error('email')
                            <div class="rounded-md bg-red-50 p-4 mt-3">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">{{ $message }}</h3>
                                    </div>
                                </div>
                            </div>
                        @enderror
            <form class="mt-8 space-y-6" action="{{ route('forgot.form') }}" method="POST" onsubmit="document.getElementById('submit').disabled=true;document.getElementById('submit').classlist.add('animate-pulse');">
                @csrf
                <input type="hidden" name="remember" value="true" />
                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input id="email" name="email" type="email" autocomplete="email"
                            class="@if ($errors->has('email')) border border-red-500 @else border border-gray-300 @endif
                            relative block w-full appearance-none rounded-md  px-3 py-2
                            text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none
                            focus:ring-indigo-500 sm:text-sm"
                            placeholder="{{session()->get('locale') === 'en' ? 'Email address' : 'Email cím'}}" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                    id="submit"
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <!-- Heroicon name: mini/key -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400">
                                <path fill-rule="evenodd"
                                    d="M8 7a5 5 0 113.61 4.804l-1.903 1.903A1 1 0 019 14H8v1a1 1 0 01-1 1H6v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a1 1 0 01.293-.707L8.196 8.39A5.002 5.002 0 018 7zm5-3a.75.75 0 000 1.5A1.5 1.5 0 0114.5 7 .75.75 0 0016 7a3 3 0 00-3-3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        {{session()->get('locale') === 'en' ? 'Reset password' : 'Küldés'}}
                    </button>
                </div>
            </form>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function setLanguage(language) {
        axios.get(`/api/set-language-for-guest/${language}`).then((res) => {
            localStorage.setItem('i18n', res.data.language);
            window.location.reload();
        })
            .catch((err) => console.log(err))
    }

</script>
</body>

</html>
