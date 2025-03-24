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
                class="mt-2 object-cover w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl"
                x-ref="postImage"
                @load="
                    let img = $el;
                    if (img.naturalHeight > img.naturalWidth) {
                        img.style.height = 'auto';
                        img.style.width = '100%';
                    } else {
                        img.style.height = 'auto';
                        img.style.width = '100%';
                    }
                ">

            

                <p class="text-sm text-gray-500" x-text="new Date(post.created_at).toLocaleString()"></p>

               

                
                <div class="flex space-x-4 mt-2">
                    <!-- Like & Comment Buttons -->
                    <!--Like button -->
                    <button @click="likePost(post.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: blue; color: white;">
                        <span x-text="post.liked_by_user ? 'Like' : 'Like'"></span>
                        (<span x-text="post.likes_count"></span>)
                    </button>
                    <!--Comment button -->
                    <button @click="post.showComments = !post.showComments" class="bg-gray-500 hover:bg-gray-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: gray; color: white;">Comment</button>

                    <!-- Delete Button (Only show if user owns the post) -->
                    <button 
                    x-show="post.user_id === currentUserId" 
                    @click="deletePost(post.id)" 
                    class="bg-red-500 hover:bg-red-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: red; color: white;">
                    Delete
                    </button>
                </div>

                <!-- Comment Section -->
                <div x-show="post.showComments" class="mt-2 p-2 bg-white border rounded">
                    <input type="text" x-model="post.newComment" placeholder="Write a comment..." class="w-full p-2 border rounded">
                    <button @click="addComment(post.id, post.newComment)" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded mt-2 transition duration-200" style="background-color: purple; color: white;">Post Comment</button>

                    <ul class="mt-2">
                        <template x-if="post.comments.length === 0">
                            <p class="text-sm text-gray-500">No Comments</p>
                        </template>
                    
                        <template x-for="comment in post.comments" :key="comment.id">
                            <li class="text-sm text-gray-700 flex justify-between items-center">
                                <span x-text="comment.content"></span>
                                <span class="text-xs text-gray-500" x-text="new Date(comment.created_at).toLocaleString()"></span>
                    
                                <!-- Edit & Delete buttons (Only show for comment owner) -->
                                <div x-show="comment.user_id === currentUserId">
                                    <button @click="editComment(comment)" class="text-blue-500 text-xs ml-2">Edit</button>
                                    <button @click="deleteComment(comment.id, post.id)" class="text-red-500 text-xs ml-2">Delete</button>
                                </div>
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
                        this.posts = data.map(post => ({ 
                        ...post, 
                        comments: [],  // Initialize comments array
                        newComment: '', 
                        showComments: false
                    }));
                    })
                    .catch(error => console.error('Error fetching posts:', error));
            },
                toggleComments(post) {
                    if (!post.showComments) {
                        this.fetchComments(post.id, post);
                    }
                    post.showComments = !post.showComments;
                },
                fetchComments(postId, post) {
                    fetch(`/posts/${postId}/comments`)
                        .then(res => res.json())
                        .then(comments => {
                            post.comments = comments.length ? comments : []; // Ensure it's always an array
                        })
                        .catch(error => console.error('Error fetching comments:', error));
                },

                addComment(postId, content) {
                    if (!content.trim()) {
                        alert("Comment cannot be empty");
                        return;
                    }

                    fetch(`/posts/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ content })
                    })
                    .then(res => res.json())
                    .then(comment => {
                        let post = this.posts.find(p => p.id === postId);
                        if (post) {
                            post.comments.push(comment); // Add new comment to UI
                            post.newComment = ''; // Clear input field
                        }
                    })
                    .catch(error => console.error('Error posting comment:', error));
                },

                deleteComment(commentId, postId) {
                    if (!confirm("Are you sure you want to delete this comment?")) return;

                    fetch(`/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(() => {
                        let post = this.posts.find(p => p.id === postId);
                        if (post) {
                            post.comments = post.comments.filter(comment => comment.id !== commentId);
                        }
                    })
                    .catch(error => console.error('Error deleting comment:', error));
                },





                uploadImage(event) {
                    let file = event.target.files[0];
                    if (!file) return;
                    this.newPost.imageFile = file; // Store file for upload
                    this.newPost.image = URL.createObjectURL(file); // Preview image
                },

                addPost() {
                let formData = new FormData();

                // Always send content, even if it's empty
                formData.append('content', this.newPost.content.trim() || '');

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
                
                // Get and log the image file before sending
                let imageFile = formData.get('image');
                console.log('Image being sent:', imageFile);
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

                likePost(postId) {
                    fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        let post = this.posts.find(p => p.id === postId);
                        if (post) {
                            post.liked_by_user = data.liked; // Update UI based on response
                            post.likes_count = data.likes_count; // Update like count dynamically
                        }
                    })
                    .catch(error => console.error('Error liking post:', error));
                },



            };
        }
    </script>
@endsection