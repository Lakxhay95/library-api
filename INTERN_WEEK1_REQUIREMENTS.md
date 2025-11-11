# Week 1 Training Project Requirements
## Library Management API - Laravel/Lumen

**Duration:** 7 Days  
**Submission:** Daily progress + Final demo on Day 7  
**Framework:** Lumen (Laravel micro-framework)  
**Language:** PHP

---

## 📋 Project Overview

You will build a complete **Library Management API** from scratch using Lumen. This project will help you understand our codebase architecture and development practices.

**What you'll build:**
- Book management (CRUD operations)
- Member management (user registration)
- Borrowing system (borrow/return books with business logic)
- Advanced search and filtering
- Background job processing
- Statistics dashboard

**Why this project?**
This mirrors the exact architecture and patterns used in our production codebase. You'll learn the service layer pattern, validation approach, and API design we use daily.

---

## 🎯 Technical Requirements

### Technology Stack
- **Framework:** Lumen 8.x or Laravel 8.x
- **Database:** MySQL 5.7+
- **PHP:** 7.4+
- **Version Control:** Git

### Architecture Requirements
You **MUST** follow this pattern (same as our codebase):

```
Controller (thin layer)
    ↓
ValidationRulesService (input validation)
    ↓
BusinessLogicService (business logic)
    ↓
Model (database interaction)
```

### Code Structure
```
app/
├── Http/Controllers/
│   ├── BookController.php
│   ├── MemberController.php
│   └── BorrowingController.php
├── Services/
│   ├── Books/
│   │   ├── BusinessLogicService.php
│   │   └── ValidationRulesService.php
│   ├── Members/
│   │   ├── BusinessLogicService.php
│   │   └── ValidationRulesService.php
│   └── Borrowings/
│       ├── BusinessLogicService.php
│       └── ValidationRulesService.php
└── Models/
    ├── Book.php
    ├── Member.php
    └── Borrowing.php
```

---

## 📅 Day-by-Day Deliverables

### **Day 1: Project Setup & Database Design**

#### What to Deliver:
1. ✅ Complete Lumen project setup
2. ✅ Database migrations for 3 tables (books, members, borrowings)
3. ✅ Database seeders with sample data
4. ✅ Git repository initialized
5. ✅ README.md with setup instructions

#### Database Schema Requirements:

**books table:**
- id (primary key)
- title (string, 255)
- author (string, 255)
- isbn (string, 50, unique)
- category (string: fiction, non-fiction, science, history, etc.)
- total_copies (integer)
- available_copies (integer)
- status (enum: active, inactive)
- timestamps

**members table:**
- id (primary key)
- name (string, 255)
- email (string, 255, unique)
- phone (string, 20)
- membership_number (string, 50, unique)
- status (enum: active, suspended)
- joined_date (date)
- timestamps

**borrowings table:**
- id (primary key)
- book_id (foreign key → books.id)
- member_id (foreign key → members.id)
- borrowed_date (date)
- due_date (date)
- returned_date (date, nullable)
- status (enum: borrowed, returned, overdue)
- late_fee (decimal, 10, 2, default 0)
- timestamps

#### Seeder Requirements:
- Minimum 20 books (various categories)
- Minimum 10 members (mix of active/suspended)
- Minimum 5 borrowing records (some borrowed, some returned)

#### What to Demo:
```bash
# Show these commands working:
php artisan migrate
php artisan db:seed

# In Tinker, show:
Book::count();      # Should return 20+
Member::count();    # Should return 10+
Borrowing::count(); # Should return 5+
```

---

### **Day 2: Book Management (CRUD)**

#### What to Deliver:
1. ✅ Book model with fillable fields
2. ✅ BookController
3. ✅ Books/ValidationRulesService
4. ✅ Books/BusinessLogicService
5. ✅ All routes defined
6. ✅ Postman collection for all endpoints

#### API Endpoints to Implement:

| Method | Endpoint | Description | Status Code |
|--------|----------|-------------|-------------|
| POST | /books/create | Create new book | 201 |
| POST | /books/list | List all books (paginated) | 200 |
| GET | /books/{id} | Get book by ID | 200 |
| PUT | /books/update/{id} | Update book | 200 |
| DELETE | /books/delete/{id} | Delete book | 200 |
| POST | /books/search | Search books | 200 |

#### Validation Rules:
- title: required, string, max 255
- author: required, string, max 255
- isbn: required, unique, string
- category: required, in allowed categories
- total_copies: required, integer, min 1
- available_copies: required, integer, min 0, less than or equal to total_copies

#### Response Format:
```json
{
    "status": true,
    "message": "Book created successfully",
    "data": {
        "id": 1,
        "title": "Sample Book",
        "author": "John Doe",
        "isbn": "978-3-16-148410-0",
        "category": "fiction",
        "total_copies": 5,
        "available_copies": 5,
        "status": "active"
    }
}
```

#### What to Demo:
- Create a book with valid data → Success
- Create a book with invalid data → Validation errors
- List books with pagination (page 1, 15 per page)
- Update a book
- Delete a book
- Search books by title

---

### **Day 3: Member Management & Relationships**

#### What to Deliver:
1. ✅ Member model with relationships
2. ✅ MemberController
3. ✅ Members/ValidationRulesService
4. ✅ Members/BusinessLogicService
5. ✅ Model relationships defined
6. ✅ Updated Postman collection

#### API Endpoints to Implement:

| Method | Endpoint | Description | Status Code |
|--------|----------|-------------|-------------|
| POST | /members/create | Register new member | 201 |
| POST | /members/list | List all members | 200 |
| GET | /members/{id} | Get member details | 200 |
| PUT | /members/update/{id} | Update member | 200 |
| DELETE | /members/delete/{id} | Delete member | 200 |
| POST | /members/search | Search members | 200 |
| GET | /members/{id}/borrowings | Get member's borrowing history | 200 |

#### Validation Rules:
- name: required, string, max 255
- email: required, email, unique
- phone: required, string, regex for 10-15 digits
- membership_number: auto-generated (format: MEM-YYYY-####)
- status: required, in [active, suspended]

#### Model Relationships to Define:
```php
// Member.php
public function borrowings() {
    return $this->hasMany(Borrowing::class);
}

// Book.php
public function borrowings() {
    return $this->hasMany(Borrowing::class);
}

// Borrowing.php
public function member() {
    return $this->belongsTo(Member::class);
}
public function book() {
    return $this->belongsTo(Book::class);
}
```

#### What to Demo:
- Create a member with unique email
- Try to create member with duplicate email → Error
- Update member status to suspended
- Get member with their borrowing history (relationship working)
- Search members by name

---

### **Day 4: Borrowing System (Business Logic)**

#### What to Deliver:
1. ✅ Borrowing model
2. ✅ BorrowingController
3. ✅ Borrowings/ValidationRulesService
4. ✅ Borrowings/BusinessLogicService
5. ✅ Complex business logic implemented
6. ✅ Updated Postman collection

#### API Endpoints to Implement:

| Method | Endpoint | Description | Status Code |
|--------|----------|-------------|-------------|
| POST | /borrowings/borrow | Borrow a book | 201 |
| POST | /borrowings/return | Return a book | 200 |
| POST | /borrowings/list | List all borrowings | 200 |
| GET | /borrowings/{id} | Get borrowing details | 200 |
| POST | /borrowings/overdue | List overdue borrowings | 200 |

#### Business Rules to Implement:

**BORROW BOOK:**
1. Check if book exists and is active
2. Check if book is available (available_copies > 0)
3. Check if member exists and is active (not suspended)
4. Check if member already has this book borrowed (prevent duplicate)
5. Decrease available_copies by 1
6. Set due_date = borrowed_date + 14 days
7. Create borrowing record with status 'borrowed'
8. Return success response

**RETURN BOOK:**
1. Check if borrowing exists
2. Check if status is 'borrowed' (prevent double return)
3. Calculate late fee:
   - If returned_date > due_date
   - Late fee = ₹10 per day
   - Example: 5 days late = ₹50
4. Increase available_copies by 1
5. Update borrowing record:
   - returned_date = today
   - status = 'returned'
   - late_fee = calculated amount
6. Return success response with late fee info

#### Validation Rules:
- member_id: required, exists in members table
- book_id: required, exists in books table
- borrowing_id: required, exists in borrowings table

#### What to Demo:

**Scenario 1: Successful Borrow**
```json
POST /borrowings/borrow
{
    "member_id": 1,
    "book_id": 5
}
Response: Success, available_copies decreased from 3 to 2
```

**Scenario 2: Book Not Available**
```json
POST /borrowings/borrow
{
    "member_id": 2,
    "book_id": 5
}
Response: Error - "Book is not available"
```

**Scenario 3: Return On Time**
```json
POST /borrowings/return
{
    "borrowing_id": 1
}
Response: Success, late_fee = 0
```

**Scenario 4: Return Late**
```json
POST /borrowings/return
{
    "borrowing_id": 2
}
Response: Success, late_fee = 50 (5 days * ₹10)
```

---

### **Day 5: Advanced Search & Statistics**

#### What to Deliver:
1. ✅ Advanced search functionality with multiple filters
2. ✅ Sorting and pagination
3. ✅ Statistics dashboard endpoint
4. ✅ Activity logging system
5. ✅ Updated Postman collection

#### Advanced Search Endpoints:

**Book Search:**
```
POST /books/search
Request Body:
{
    "title": "harry",              // Partial match
    "author": "rowling",           // Partial match
    "category": "fiction",         // Exact match
    "status": "active",            // Exact match
    "available_only": true,        // Boolean filter
    "sort_by": "title",            // Field to sort
    "sort_order": "asc",           // asc or desc
    "per_page": 15,                // Pagination
    "page": 1                      // Page number
}
```

**Member Search:**
```
POST /members/search
Request Body:
{
    "name": "john",                // Partial match
    "email": "gmail",              // Partial match
    "status": "active",            // Exact match
    "sort_by": "name",
    "sort_order": "asc",
    "per_page": 15,
    "page": 1
}
```

#### Statistics Dashboard:
```
GET /statistics/dashboard
Response:
{
    "status": true,
    "data": {
        "total_books": 120,
        "total_members": 45,
        "total_borrowings": 234,
        "active_borrowings": 23,
        "overdue_borrowings": 5,
        "total_available_books": 97,
        "suspended_members": 2,
        "total_late_fees_collected": 1450.00,
        "books_borrowed_today": 8,
        "books_returned_today": 5
    }
}
```

#### Activity Logging:
Implement a logging system that tracks:
- Book created/updated/deleted
- Member created/updated/deleted
- Book borrowed/returned

Store in database table `activity_logs`:
- user_id
- action (create/update/delete/borrow/return)
- entity_type (book/member/borrowing)
- entity_id
- details (JSON)
- ip_address
- created_at

#### What to Demo:
- Search books with multiple filters
- Search with sorting (ascending/descending)
- Search with pagination working correctly
- Show statistics dashboard with real data
- Show activity logs for recent actions

---

## 🎯 Final Deliverable (Day 5 End)

### Complete Project Submission:

**Part 1: End-to-End Scenario (10 min)**
1. Create a new member
2. Add a new book (or import by ISBN)
3. Member borrows the book
4. Search for the borrowed book
5. Member returns the book late (show late fee calculation)
6. Show member's borrowing history
7. Show statistics dashboard

**Part 2: Error Handling (3 min)**
1. Try to borrow unavailable book → Show error
2. Try to borrow with suspended member → Show error
3. Show validation errors with invalid data
---

## 📝 Daily Submission Format

### What to Submit Each Day:

**Submit via:** [Git repository / Shared folder / Email]

**Format:**
```
Subject: Day [X] Submission - [Your Name]

Git Repository: [link]
Branch: [branch name]

Completed Today:
- [List what you completed]

Tomorrow's Plan:
- [What you plan to work on]
```

---

## ⚙️ Setup Instructions

### Before You Start:

1. **Install Required Software:**
   ```bash
   - PHP 7.4 or higher
   - Composer
   - MySQL 5.7+
   - Git
   - Postman
   ```

2. **Create New Lumen Project:**
   ```bash
   composer create-project --prefer-dist laravel/lumen library-api
   cd library-api
   ```

3. **Configure Database:**
   ```bash
   # Edit .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=library_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Initialize Git:**
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   ```

5. **Start Development:**
   ```bash
   php -S localhost:8000 -t public
   ```

---

## 💡 Important Notes

### DO's ✅
- Commit your code daily
- Test each endpoint immediately after creating it
- Follow the service layer pattern strictly
- Handle all errors properly
- Write clean, readable code
- Comment complex business logic
- Ask questions when stuck (don't waste hours)

### DON'Ts ❌
- Don't skip validation
- Don't hardcode values (use config/env)
- Don't ignore error handling
- Don't write everything in controller (use services)
- Don't copy-paste without understanding
- Don't submit untested code
- Don't leave debugging code (dd(), var_dump())


**Resources:**
- Laravel Documentation: https://laravel.com/docs
- Lumen Documentation: https://lumen.laravel.com/docs
- Our codebase: [Repository link] (for reference only)

---

## ✅ Final Checklist

Before submitting final project:

- [ ] All 5 days completed
- [ ] All endpoints working and tested
- [ ] Service layer pattern followed throughout
- [ ] All business rules implemented correctly
- [ ] Error handling on all endpoints
- [ ] Validation on all inputs
- [ ] Database relationships working
- [ ] Code committed to Git
- [ ] Code is clean and commented
- [ ] Demo prepared
- [ ] No debugging code left
- [ ] No console errors


**Document Version:** 1.0  
**Last Updated:** November 2025

