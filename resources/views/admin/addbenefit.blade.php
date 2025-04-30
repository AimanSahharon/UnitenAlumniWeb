@extends('layouts.app')

@section('content')
<div class="container-wrapper">
    <form action="{{ route('benefits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <br>
        <input type="text" name="title" placeholder="Card Title" required class="form-control mb-2">
        <textarea name="content" placeholder="Optional Text" class="form-control mb-2"></textarea>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control mb-2" onchange="addLinkInputs(this)">

        <!-- Dynamic Link Inputs will appear here -->
        <div id="linkInputs"></div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Add Card</button>
        </div>
        <br>
    </form>
</div>

<script>
function addLinkInputs(input) {
    const linkInputsDiv = document.getElementById('linkInputs');
    linkInputsDiv.innerHTML = '';

    for (let i = 0; i < input.files.length; i++) {
        const label = document.createElement('label');
        label.textContent = `Link for Image ${i+1} (optional):`;

        const linkInput = document.createElement('input');
        linkInput.type = 'url';
        linkInput.name = 'image_links[]';
        linkInput.className = 'form-control mb-2';

        linkInputsDiv.appendChild(label);
        linkInputsDiv.appendChild(linkInput);
    }
}
</script>

<style>
.container-wrapper {
    max-width: 90%;
    width: 600px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    justify-content: center;
    align-items: center;
}
</style>
@endsection
