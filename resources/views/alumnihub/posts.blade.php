@extends('layouts.alumnihub')

@section('tab-content')
    <div class="max-w-2xl mx-auto p-4" x-data="postApp({{ auth()->id() }})" x-init="fetchPosts()">
        <h2 class="text-xl font-bold mb-4">Create a Post</h2>

        <!-- ✅ Post Input Form (Now at the Top) -->
        <div class="bg-red p-4 rounded shadow">
            <textarea x-model="newPost.content" maxlength="300" class="w-full border p-2 rounded" placeholder="Write something..."></textarea>
            <input type="file" @change="uploadImage" class="mt-2">
            <button @click="addPost" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded mt-2 transition duration-200" style="background-color: purple; color: white;">Post</button>



        </div>

        <!-- 📝 Display Posts Below -->
        <template x-for="post in posts" :key="post.id">
            <div class="bg-gray-100 p-4 mt-4 rounded shadow">
                <!-- Display User Name -->
                <p class="text-lg"><strong x-text="post.user ? post.user.name : 'Unknown User'"></strong></p>

                <p x-text="post.content"></p>
                <!-- Display the image based on whether it is landscape or portrait ot preserve its aspect ratio. @ load is to fix the issue with when user refresh the images resize on its own -->
                <img 
                x-bind:src="post.image ? post.image : ''" 
                x-show="post.image" 
                class="mt-2 object-cover"
                x-ref="postImage"
                @load="
                let img = $el;
                if (img.naturalHeight > img.naturalWidth) {
                    img.style.height = '500px';
                    img.style.width = '300px';
                } else {
                    img.style.height = '300px';
                    img.style.width = '500px';
                }">

                <p class="text-sm text-gray-500" x-text="new Date(post.created_at).toLocaleString()"></p>

                <!-- Delete Button (Only show if user owns the post) -->
                <button 
                x-show="post.user_id === currentUserId" 
                @click="deletePost(post.id)" 
                class="text-red-500 text-xs absolute top-2 right-2">
                Delete
                </button>

                <!-- Like & Comment Buttons -->
                <div class="flex space-x-4 mt-2">
                    <button @click="likePost(post.id)" class="text-blue-500">Like (<span x-text="post.likes.length"></span>)</button>
                    <button @click="post.showComments = !post.showComments" class="text-blue-500">Comment</button>
                </div>

                <!-- Comment Section -->
                <div x-show="post.showComments" class="mt-2 p-2 bg-white border rounded">
                    <input type="text" x-model="post.newComment" placeholder="Write a comment..." class="w-full p-2 border rounded">
                    <button @click="addComment(post.id, post.newComment)" class="bg-blue-500 text-white px-2 py-1 rounded mt-1">Post Comment</button>

                    <ul class="mt-2">
                        <template x-for="comment in post.comments">
                            <li class="text-sm text-gray-700 flex justify-between">
                                <span x-text="comment.content"></span>
                                <span class="text-xs text-gray-500" x-text="new Date(comment.created_at).toLocaleString()"></span>
                                <button @click="deleteComment(comment.id)" class="text-red-500 text-xs ml-2">Delete</button>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </template>
    </div>

    <script>
        function postApp(currentUserId) {
        return {
            posts: [],
            currentUserId: currentUserId, // Store the authenticated user ID
            newPost: { content: '', image: '' },

            fetchPosts() {
                fetch('/posts')
                    .then(res => res.json())
                    .then(data => {
                        this.posts = data;
                    })
                    .catch(error => console.error('Error fetching posts:', error));
            },


                uploadImage(event) {
                    let file = event.target.files[0];
                    if (!file) return;
                    this.newPost.imageFile = file; // Store file for upload
                },

                addPost() {
                let formData = new FormData();

                // Always send content, even if it's empty
                //formData.append('content', this.newPost.content.trim() || '');
                if (this.newPost.content.trim()) {
                formData.append('content', this.newPost.content.trim());
                }


                // Append image if available
                if (this.newPost.imageFile) {
                    formData.append('image', this.newPost.imageFile);
                }

                // Prevent completely empty posts
                if (!this.newPost.content.trim() && !this.newPost.imageFile) {
                    alert("Please enter text or select an image.");
                    return;
                }

                fetch('/posts', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    this.posts.unshift(data); // Add new post at the top
                    this.newPost.content = '';
                    this.newPost.imageFile = null;
                })
                .catch(error => console.error('Error posting:', error));
            },


                deletePost(id) {
                    if (!confirm("Are you sure you want to delete this post?")) return;

                    fetch(`/posts/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(() => {
                        this.posts = this.posts.filter(post => post.id !== id);
                    })
                    .catch(error => console.error('Error deleting post:', error));
                },

                    deletePost(id) {
                    if (!confirm("Are you sure you want to delete this post?")) return;

                    fetch(`/posts/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(() => {
                        this.posts = this.posts.filter(post => post.id !== id);
                    })
                    .catch(error => console.error('Error deleting post:', error));
                }
            };
        }
    </script>
@endsection