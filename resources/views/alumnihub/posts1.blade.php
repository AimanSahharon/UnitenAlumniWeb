@extends('layouts.alumnihub')

@section('tab-content')
    <div class="max-w-2xl mx-auto p-4" x-data="postApp()" x-init="fetchPosts()">
        <h2 class="text-xl font-bold mb-4">Create a Post</h2>

        <!-- ✅ Move Posts Section ABOVE the Input Form -->
        <template x-for="post in posts" :key="post.id">
            <div class="bg-gray-100 p-4 mt-4 rounded shadow">
                <p x-text="post.content"></p>
                <img x-bind:src="post.image ? post.image : ''" x-show="post.image" class="mt-2 w-40 h-40 object-cover">
                <p class="text-sm text-gray-500" x-text="new Date(post.created_at).toLocaleString()"></p>

                <!-- 🗑️ Delete Button (Only show if user owns the post) -->
        <button @click="deletePost(post.id)" class="text-red-500 text-xs absolute top-2 right-2">Delete</button>

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

        <!-- ✅ Post Input Form (Fixed at Bottom) -->
        <div class="bg-white p-4 rounded shadow fixed bottom-0 left-0 w-full z-50">
            <textarea x-model="newPost.content" maxlength="300" class="w-full border p-2 rounded" placeholder="Write something..."></textarea>
            <input type="file" @change="uploadImage" class="mt-2">
            <button @click="addPost" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Post</button>
        </div>

        <!-- Add bottom padding to avoid overlap with posts -->
        <div class="pb-24"></div>

        
    </div>

    <script>
        function postApp() {
            return {
                posts: [],
                newPost: { content: '', image: '' },
                fetchPosts() {
                    fetch('/posts')
                        .then(res => {
                            if (!res.ok) throw new Error('Failed to fetch posts');
                            return res.json();
                        })
                        .then(data => {
                            console.log('Fetched Posts:', data); // Debugging line
                            this.posts = data;
                        })
                        .catch(error => console.error('Error fetching posts:', error));
                },

                uploadImage(event) {
                    let file = event.target.files[0];
                    if (!file) return;

                    let formData = new FormData();
                    formData.append('image', file);

                    fetch('/upload-image', {  // 👈 Change this to match your Laravel route
                        method: 'POST',
                        headers: { 
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.newPost.image = data.image_url;  // 👈 Store the uploaded image URL
                    })
                    .catch(error => console.error('Error uploading image:', error));
                },

                addPost() {
                let formData = new FormData();
                formData.append('content', this.newPost.content);

                if (this.newPost.image) {
                    formData.append('image', this.newPost.imageFile); // Send file instead of URL
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
                    this.newPost.image = '';
                })
                .catch(error => console.error('Error posting:', error));
            },

            uploadImage(event) {
                let file = event.target.files[0];
                if (!file) return;
                this.newPost.imageFile = file; // Store file for upload
            },

                    deleteComment(id) {
                    fetch(`/comments/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(() => {
                        this.posts = this.posts.map(post => {
                            post.comments = post.comments.filter(comment => comment.id !== id);
                            return post;
                        });
                    })
                    .catch(error => console.error('Error deleting comment:', error));
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
                    this.posts = this.posts.filter(post => post.id !== id); // Remove from UI
                })
                .catch(error => console.error('Error deleting post:', error));
            },


            }
        }


    </script>
@endsection
