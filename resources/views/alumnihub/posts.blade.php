@extends('layouts.alumnihub')

@section('tab-content')
<script>
    window.currentUserId = {{ auth()->id() }};
    window.userLevel = {{ auth()->user()->user_level }};
</script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- improve visual using Tailwind -->
    <div class="max-w-2xl mx-auto p-4" x-data="postApp({{ auth()->id() }})" x-init="fetchPosts()">
        <h2 class="text-xl font-bold mb-4">Create a Post</h2>

        <!-- 🔎 Search Bar -->
        <input type="text" x-model="searchQuery" @input="filterPosts"
       placeholder="Search posts by author or content..." style="width: 100%;"
       class="w-full p-3 border rounded-lg mb-4 shadow-md">

        

        <!-- ✅ Post Input Form (Now at the Top) -->
        <div class="bg-red p-4 rounded shadow">
            <textarea x-model="newPost.content" maxlength="300" class="w-full border p-2 rounded" placeholder="Write something..."></textarea>
            <input type="file" @change="uploadImage" class="mt-2">
            <button @click="addPost" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded mt-2 transition duration-200" style="background-color: purple; color: white;">Post</button>



        </div>

        <!-- 📝 Display Posts Below -->
        <template x-for="post in filteredPosts" :key="post.id">
            <div class="bg-gray-100 p-4 mt-4 rounded shadow">
                <!-- Display User Name -->
                <p class="text-lg"><strong x-text="post.user ? post.user.name : 'Unknown User'"></strong></p>

                <template x-if="post.editing">
                    <div>
                        <textarea x-model="post.editedContent" class="w-full border p-2 rounded"></textarea>
                        
                <!-- Image Preview (When Editing) -->
                <template x-if="post.editedImage">
                    <img :src="post.editedImage" 
                        class="mt-2 object-cover w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl"
                        x-ref="editedPostImage"
                        @load="
                            let img = $el;
                            if (img.naturalHeight > img.naturalWidth) {
                                img.style.width = '100%';
                                img.style.height = 'auto';
                            } else {
                                img.style.width = '100%';
                                img.style.height = 'auto';
                            }
                        ">
                </template>

                
                        <!-- Upload New Image -->
                        <input type="file" @change="updateImage($event, post)" class="mt-2">
                
                        <!-- Remove Image Button -->
                        <button @click="removeImage(post)" class="bg-red-500 text-white px-3 py-1 rounded mt-2" style="background-color: red; color: white;">
                            Remove Image
                        </button>
                    </div>
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
            
                <p class="text-sm text-gray-500">
                    <span x-text="new Date(post.created_at).toLocaleString()"></span>
                </p>
                
                <template x-if="post.updated_at && post.updated_at !== post.created_at">
                    <p class="text-sm text-gray-500">
                        Updated at: <span x-text="new Date(post.updated_at).toLocaleString()"></span>
                    </p>
                </template>
                
                <div class="flex space-x-4 mt-2">
                    <!-- Like & Comment Buttons -->
                    <!--Like button -->
                    <button @click="likePost(post.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: blue; color: white;">
                        <span x-text="post.liked_by_user ? 'Like' : 'Like'"></span>
                        (<span x-text="post.likes_count"></span>)
                    </button>
                    <!--Comment button -->
                    <button @click="post.showComments = !post.showComments" class="bg-gray-500 hover:bg-gray-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: gray; color: white;">Comment</button>

                    <button @click="editPost(post)" 
                    x-show="post.user_id === currentUserId"
                    class="bg-orange-500 hover:bg-orange-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: orange; color: white;">
                    <span x-text="post.editing ? 'Cancel' : 'Edit'"></span>
                    </button>
            
                    <button x-show="post.editing" @click="saveEditedPost(post)" class="bg-green-500 hover:bg-green-700 text-white font-semibold px-2 py-1 rounded transition duration-200" style="background-color: green; color: white;">Save</button>


                    <!-- Delete Button (Only show if user owns the post or admin) -->
                    <button 
                    x-show="post.user_id === currentUserId || userLevel === 0" 
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
                                    <!--<p class="text-xs font-bold text-red-500" x-text="comment.user ? comment.user.name : 'Unknown User'"></p> -->
                                    <p class="text-lg"><strong x-text="comment.user ? comment.user.name : 'Unknown User'"></strong></p>

                                    
                                    <!-- Conditional Rendering: Show Text or Input Field -->
                                    <template x-if="comment.editing">
                                        <input type="text" x-model="comment.editedContent" class="w-full p-2 border rounded" />
                                    </template>
                                    <template x-if="!comment.editing">
                                        <p class="text-sm text-gray-700 mt-1" x-text="comment.content"></p>
                                    </template>

                                     <!-- ✅ Display the timestamp for when the comment was created -->
                                    <p class="text-xs text-gray-500">
                                        <span x-text="new Date(comment.created_at).toLocaleString()"></span>
                                    </p>
                        
                                    <template x-if="comment.updated_at && comment.updated_at !== comment.created_at">
                                        <p class="text-xs text-gray-500">
                                            Updated at: <span x-text="new Date(comment.updated_at).toLocaleString()"></span>
                                        </p>
                                    </template>
                                    
                        
                                    <div x-show="comment.user_id === currentUserId || userLevel === 0" class="mt-2 flex space-x-2">
                                        <!-- Edit Button -->
                                        <button @click="editComment(comment)"
                                            class="bg-orange-500 hover:bg-orange-700 text-white font-semibold px-2 py-1 rounded transition duration-200"
                                            style="background-color: orange; color: white;">
                                            <span x-text="comment.editing ? 'Cancel' : 'Edit'"></span>
                                        </button>

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

    <!--Script below is Alpine.js to create function for posts e.g create postm edit and delete post -->
    <script>
        function postApp(currentUserId) {
        return {
            posts: [],
            filteredPosts: [], // Stores posts after filtering
            searchQuery: "", // Stores search input
            currentUserId: currentUserId, // Store the authenticated user ID

            editPost(post) {
                // Toggle edit mode
                post.editing = !post.editing; 
               // If switching to edit mode, populate edit fields
                if (post.editing) {
                    post.editedContent = post.content; // Pre-fill input with existing content
                    post.editedImage = post.image; // Keep track of existing image
                    post.imageFile = null; // Reset file input
                }
            },

            updateImage(event, post) {
                let file = event.target.files[0];
                if (!file) return;
                
                post.imageFile = file;
                post.editedImage = URL.createObjectURL(file); // Show preview of the new image
            },

            removeImage(post) {
                post.editedImage = null; // Clear the preview
                post.imageFile = null; // Ensure no new file is selected
                post.removeImageFlag = true; // Mark for backend removal
            },


            saveEditedPost(post) {
                // Ensure editedContent is not null/undefined before calling trim
                const editedContent = post.editedContent ? post.editedContent.trim() : ''; //if content is null then add ''
                
                if (!editedContent && !post.imageFile && !post.editedImage) {
                    // If there's no content or image, show an error
                    alert("Post must have text or an image.");
                    return;
                }

                let formData = new FormData();
                formData.append('_method', 'PUT'); // Required for Laravel to accept PUT
                formData.append('content', editedContent || ''); // Use the trimmed content

                if (post.imageFile) {
                    formData.append('image', post.imageFile);
                }

                if (post.removeImageFlag) {
                    formData.append('remove_image', 'true');
                }

                fetch(`/posts/${post.id}`, {
                    method: 'POST', // Laravel needs `_method: 'PUT'` for FormData
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
                    post.image = updatedPost.image; // Update the displayed image
                    post.updated_at = updatedPost.updated_at; // Update the timestamp
                    post.editing = false; // Exit edit mode
                })
                .catch(error => console.error('Error updating post:', error));
            },




            editComment(comment) {
                //comment.editing = true;
                //comment.editedContent = comment.content || ''; // Pre-fill with existing content
                comment.editing = !comment.editing;
                if (comment.editing) {
                    comment.editedContent = comment.content || ''; // Pre-fill when entering edit mode
                }
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
                            existingComment.updated_at = updatedComment.updated_at; // Update timestamp
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
                    this.filteredPosts = this.posts; // Set initial filtered list
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
                        // Remove post from both posts and filteredPosts
                        this.posts = this.posts.filter(post => post.id !== id);
                        this.filteredPosts = this.filteredPosts.filter(post => post.id !== id);
                        this.filterPosts(); //after the post is delete refresh and show the updated posts
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

                filterPosts() {
                    if (!this.searchQuery.trim()) {
                        this.filteredPosts = this.posts; // Reset when input is empty
                        return;
                    }

                    let query = this.searchQuery.toLowerCase();
                    
                    this.filteredPosts = this.posts.filter(post => {
                        let author = post.user ? post.user.name.toLowerCase() : '';
                        let content = post.content ? post.content.toLowerCase() : '';

                        return author.includes(query) || content.includes(query);
                    });
                },



            };
        }
    </script>
@endsection