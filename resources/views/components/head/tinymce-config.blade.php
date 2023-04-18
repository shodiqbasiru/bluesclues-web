
<script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
    skin: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "oxide-dark" : ""),
    content_css: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "")
  });
</script>
