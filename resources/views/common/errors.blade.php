<!-- LaravelのBladeテンプレートエンジンを使っているので -->
<!--phpのタグでくくる必要はない。アット以下の制御構文で記述している-->

@if (count($errors) > 0)
<div>
  <div class="font-medium text-red-600">
    {{ __('Whoops! Something went wrong.') }}
  </div>

  <ul class="mt-3 list-disc list-inside text-sm text-red-600">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

