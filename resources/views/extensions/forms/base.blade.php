@if($form->url)
    <form method="POST" action="{{ $form->url }}">
@else
    <form>
@endif

@csrf

@foreach($form->getInputs() as $input)
    @include('extensions.forms.' . $input->getViewPath(), ['input' => $input])
@endforeach

    <div class="mt-6">
        <button class="bg-green-500 text-white rounded py-2 px-4">
            Send
        </button>
    </div>
</form>
