<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books Management</title>
</head>
<body>

<h2>Books Management</h2>

<!-- Search -->
<input type="text" id="searchInput" placeholder="Search books by keyword">
<button onclick="searchBooks()">Search</button>

<!-- Create New Book -->
<button onclick="document.getElementById('createModal').style.display='block'">
    Create New Book
</button>

<hr>

<!-- Books List -->
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="booksTable"></tbody>
</table>


<!-- CREATE MODAL -->
<div id="createModal" 
     style="display:none; background:#00000090; position:fixed; top:0; left:0; 
     width:100%; height:100%; display:flex; justify-content:center; align-items:center;">
    
    <div style="background:white; padding:20px; border-radius:10px; width:400px;">

        <h3>Create Book</h3>

        <label>Title</label>
        <input type="text" id="create_title"><br><br>

        <label>Author</label>
        <input type="text" id="create_author"><br><br>

        <label>Category</label>
        <input type="text" id="create_category"><br><br>

        <label>ISBN</label>
        <input type="text" id="create_isbn"><br><br>

        <label>Total Copies</label>
        <input type="number" id="create_total"><br><br>

        <button onclick="createBook()">Create</button>
        <button onclick="document.getElementById('createModal').style.display='none'">Close</button>

    </div>
</div>


<!-- EDIT MODAL -->
<div id="editModal" style="display:none; background:#00000090; position:fixed; 
     top:0; left:0; width:100%; height:100%; display:flex; justify-content:center; align-items:center;">
    
    <div style="background:white; padding:20px; border-radius:10px; width:400px;">

        <h3>Edit Book</h3>

        <input type="hidden" id="edit_id">

        <label>Title</label>
        <input type="text" id="edit_title"><br><br>

        <label>Author</label>
        <input type="text" id="edit_author"><br><br>

        <label>Category</label>
        <input type="text" id="edit_category"><br><br>

        <label>ISBN</label>
        <input type="text" id="edit_isbn"><br><br>

        <button onclick="updateBook()">Update</button>
        <button onclick="document.getElementById('editModal').style.display='none'">Close</button>

    </div>
</div>


<script>
    // Load All Books
    function loadBooks() {
        fetch('/api/books/list')
            .then(res => res.json())
            .then(response => {

                let books = response.data.data;

                let rows = "";
                books.forEach(book => {
                    rows += `
                        <tr>
                            <td>${book.id}</td>
                            <td>${book.title}</td>
                            <td>${book.author}</td>
                            <td>${book.category}</td>
                            <td>${book.available_copies}</td>
                            <td>
                                <button onclick="editBook(${book.id})">Edit</button>
                                <button onclick="deleteBook(${book.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });

                document.getElementById("booksTable").innerHTML = rows;
            })
            .catch(err => console.error("Error loading books:", err));
    }


    // Create Book
    function createBook() {

        let data = {
            title: document.getElementById("create_title").value,
            author: document.getElementById("create_author").value,
            category: document.getElementById("create_category").value,
            isbn: document.getElementById("create_isbn").value,
            total_copies: document.getElementById("create_total").value
        };

        fetch('/api/books/create', {
            method: "POST",
            headers: { 
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(bodyData)
        })

        .then(res => res.json())
        .then(resp => {
            alert("Book created successfully!");
            document.getElementById("createModal").style.display = "none";
            loadBooks();
        });
    }


    // Search Books
    function searchBooks() {
        let keyword = document.getElementById("searchInput").value;

        fetch('/api/books/search', {
            method: 'POST',
            headers: { 
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ keyword })
        })

        .then(res => res.json())
        .then(data => {
            let rows = "";
            data.data.forEach(book => {
                rows += `
                    <tr>
                        <td>${book.id}</td>
                        <td>${book.title}</td>
                        <td>${book.author}</td>
                        <td>${book.category}</td>
                        <td>${book.available_copies}</td>
                        <td>
                            <button onclick="editBook(${book.id})">Edit</button>
                            <button onclick="deleteBook(${book.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById("booksTable").innerHTML = rows;
        });
    }


    // Delete Book
    function deleteBook(id) {
        fetch(`/api/books/delete/${id}`, { method: 'DELETE' })
        .then(res => res.json())
        .then(data => {
            alert("Book deleted!");
            loadBooks();
        });
    }


    // Open Edit Modal & Fill Values
    function editBook(id) {
        fetch(`/api/books/${id}`)
            .then(res => res.json())
            .then(response => {

                let book = response.data;

                document.getElementById("edit_id").value = book.id;
                document.getElementById("edit_title").value = book.title;
                document.getElementById("edit_author").value = book.author;
                document.getElementById("edit_category").value = book.category;
                document.getElementById("edit_isbn").value = book.isbn;

                document.getElementById("editModal").style.display = "block";
            });
    }


    // Update Book
    function updateBook() {

        let id = document.getElementById("edit_id").value;

        let bodyData = {
            title: document.getElementById("edit_title").value,
            author: document.getElementById("edit_author").value,
            category: document.getElementById("edit_category").value,
            isbn: document.getElementById("edit_isbn").value
        };

        fetch(`/api/books/update/${id}`, {
            method: "PUT",
            headers: { 
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(bodyData)
        })

        .then(res => res.json())
        .then(resp => {
            alert("Book updated!");
            document.getElementById("editModal").style.display = "none";
            loadBooks();
        });
    }

    loadBooks();
</script>

</body>
</html>

