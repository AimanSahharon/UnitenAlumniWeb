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

                <template x-if="post.editing">
                    <textarea x-model="post.editedContent" class="w-full border p-2 rounded"></textarea>
                </template>
                <template x-if="!post.editing">
                    <p x-text="post.content"></p>
                </template>
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

                    <button @click="editPost(post)" x-show="post.user_id === currentUserId" class="bg-orange-500 hover:bg-orange-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: orange; color: white;">Edit</button>
                    <button x-show="post.editing" @click="saveEditedPost(post)" class="bg-green-500 hover:bg-green-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: green; color: white;">Save</button>


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
                    
                        <template x-for="(comment, index) in [...post.comments].reverse()" :key="comment.id">
                            <div>
                                <div class="bg-gray-100 p-3 rounded shadow-md mt-2">
                                    <p class="text-xs font-black text-gray-800" x-text="comment.user ? comment.user.name : 'Unknown User'"></p>
                                    
                                    <!-- Conditional Rendering: Show Text or Input Field -->
                                    <template x-if="comment.editing">
                                        <input type="text" x-model="comment.editedContent" class="w-full p-2 border rounded" />
                                    </template>
                                    <template x-if="!comment.editing">
                                        <p class="text-sm text-gray-700 mt-1" x-text="comment.content"></p>
                                    </template>
                        
                                    <p class="text-xs text-gray-500 mt-1" x-text="new Date(comment.created_at).toLocaleString()"></p>
                        
                                    <div x-show="comment.user_id === currentUserId" class="mt-1">
                                        <!-- Edit Button -->
                                        <button @click="editComment(comment)" class="bg-yellow-500 hover:bg-yellow-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: rgb(243, 243, 108); color: white;">Edit</button>
                                        <button @click="deleteComment(comment.id, post.id)" class="bg-red-500 hover:bg-red-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: red; color: white;">Delete</button>
                                        
                                        <!-- Save Button (Appears When Editing) -->
                                        <button x-show="comment.editing" @click="saveEditedComment(comment, post.id)" class="bg-green-500 hover:bg-green-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: green; color: white;">Save</button>
                                    </div>
                                </div>
                        
                                <hr x-show="index !== post.comments.length - 1" class="border-gray-300 my-2">
                            </div>
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

            editPost(post) {
                post.editing = true;
                post.editedContent = post.content; // Pre-fill input with existing content
            },

            saveEditedPost(post) {
                if (!post.editedContent.trim() && !post.imageFile) {
                    alert("Post content cannot be empty");
                    return;
                }

                let formData = new FormData();
                formData.append('_method', 'PUT'); // Laravel requires this for FormData PUT requests
                formData.append('content', post.editedContent.trim() || '');

                if (post.imageFile) {
                    formData.append('image', post.imageFile);
                }

                fetch(`/posts/${post.id}`, {
                    method: 'POST', // Use POST with `_method=PUT` for Laravel to recognize it as PUT
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error('Failed to update post');
                    return res.json();
                })
                .then(updatedPost => {
                    post.content = updatedPost.content;
                    post.image = updatedPost.image;
                    post.editing = false;
                })
                .catch(error => console.error('Error updating post:', error));
            },






            editComment(comment) {
                comment.editing = true;
                comment.editedContent = comment.content || ''; // Pre-fill with existing content
            },

            saveEditedComment(comment, postId) {
                if (!comment.editedContent.trim()) {
                    alert("Comment cannot be empty");
                    return;
                }

                fetch(`/comments/${comment.id}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ content: comment.editedContent })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('Failed to update comment');
                    }
                    return res.json();
                })
                .then(updatedComment => {
                    let post = this.posts.find(p => p.id === postId);
                    if (post) {
                        let existingComment = post.comments.find(c => c.id === comment.id);
                        if (existingComment) {
                            existingComment.content = updatedComment.content; // Update UI
                            existingComment.editing = false; // Exit edit mode
                            existingComment.editedContent = ""; // Clear input
                        }
                    }
                })
                .catch(error => console.error('Error updating comment:', error));
            },




            newPost: { content: '', image: '' },

            fetchPosts() {
                fetch('/posts')
                    .then(res => res.json())
                    .then(data => {
                        this.posts = data.map(post => ({ 
                        ...post, 
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
                            // **Instead of pushing, re-fetch the comments from the server**
                            this.fetchComments(postId, post);
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