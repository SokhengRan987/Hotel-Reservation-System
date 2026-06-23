# Image Upload Fix - Hotel Booking System

## Problem Summary

You were getting a **404 (Not Found)** error when trying to upload and display room images in the admin interface. The images were being uploaded to storage but couldn't be accessed from the user interface.

**Error:** `Failed to load resource: the server responded with a status of 404 (Not Found)`

## Root Cause

The Laravel storage symbolic link was not created. Laravel uses a symlink to make files in the `storage/app/public` directory accessible via the public web folder. Without this symlink, all image URLs returned 404 errors.

## Solution Applied

### ✅ What Was Fixed

1. **Created Storage Symlink**: Ran `php artisan storage:link` to create the symlink connecting `public/storage` to `storage/app/public`
2. **Created Storage Directories**: Ensured `storage/app/public/rooms` directory exists for room images
3. **Verified Configuration**: Confirmed that `config/filesystems.php` has the correct configuration

## Architecture Overview

### How Image Upload/Display Works:

```
┌─────────────────────────────────────────────────────────────┐
│  Admin Form (create.blade.php / edit.blade.php)             │
│  ├─ User selects image file                                 │
│  └─ Form includes: enctype="multipart/form-data"            │
└──────────────┬──────────────────────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────────────────────┐
│  AdminRoomController                                         │
│  ├─ store() - Saves new room with image                     │
│  ├─ update() - Updates room and replaces image              │
│  └─ destroy() - Deletes room and its image file             │
└──────────────┬──────────────────────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────────────────────┐
│  Storage Disk Configuration (filesystems.php)               │
│  ├─ Disk: 'public'                                          │
│  ├─ Root: storage/app/public                                │
│  ├─ URL: /storage                                           │
│  └─ Store path: $request->file('image')->store('rooms',    │
│                                          'public')           │
└──────────────┬──────────────────────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────────────────────┐
│  Storage Directory Structure                                 │
│  storage/                                                    │
│  └── app/                                                    │
│      └── public/ ←── Symlinked to public/storage            │
│          └── rooms/                                          │
│              ├── image1.jpg                                  │
│              ├── image2.png                                  │
│              └── ...                                         │
└──────────────┬──────────────────────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────────────────────┐
│  Public Symlink (Now Working!)                              │
│  public/storage/ ──→ storage/app/public/                    │
│  └── rooms/                                                 │
│      ├── image1.jpg  (accessible via /storage/rooms/...)   │
│      └── ...                                                │
└──────────────┬──────────────────────────────────────────────┘
               │
               ↓
┌─────────────────────────────────────────────────────────────┐
│  View Templates (Display Images)                            │
│  ├─ admin/rooms/index.blade.php                             │
│  ├─ admin/rooms/edit.blade.php                              │
│  ├─ customer/rooms/index.blade.php                          │
│  └─ customer/rooms/show.blade.php                           │
│                                                             │
│  Image URL: {{ asset('storage/' . $room->image) }}         │
│  Final URL: /storage/rooms/image.jpg                        │
└─────────────────────────────────────────────────────────────┘
```

## File Changes & Configuration

### 1. **AdminRoomController.php** (Already Correctly Implemented)

Location: `app/Http/Controllers/Admin/AdminRoomController.php`

**Create Operation:**

```php
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('rooms', 'public');
    $data['image'] = $imagePath;
}
```

**Update Operation:**

```php
if ($request->hasFile('image')) {
    // Delete old image if exists
    if ($room->image && Storage::disk('public')->exists($room->image)) {
        Storage::disk('public')->delete($room->image);
    }
    $imagePath = $request->file('image')->store('rooms', 'public');
    $data['image'] = $imagePath;
}
```

**Delete Operation:**

```php
if ($room->image && Storage::disk('public')->exists($room->image)) {
    Storage::disk('public')->delete($room->image);
}
$room->delete();
```

### 2. **Room Model** (Already Correctly Implemented)

Location: `app/Models/Room.php`

```php
protected $fillable = ['number','type','description','price','capacity','features','image'];
```

### 3. **Views - Image Display**

**Admin Index** (`resources/views/admin/rooms/index.blade.php`):

```blade
@if($room->image)
    <img src="{{ asset('storage/' . $room->image) }}" alt="Room {{ $room->number }}" />
@else
    <div>No image</div>
@endif
```

**Admin Create/Edit** (`resources/views/admin/rooms/create.blade.php` & `edit.blade.php`):

```blade
<input type="file" name="image" accept="image/*" />
```

**Customer Views** (`resources/views/customer/rooms/index.blade.php` & `show.blade.php`):

```blade
@if($room->image)
    <img src="{{ asset('storage/'.$room->image) }}" alt="Room {{ $room->number }}" />
@endif
```

### 4. **Filesystem Configuration** (`config/filesystems.php`)

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
    'throw' => false,
],

'links' => [
    public_path('storage') => storage_path('app/public'),
],
```

## Setup Steps (What Was Done)

### Step 1: Create Storage Symlink

```bash
php artisan storage:link
```

**Output:** `The [D:\Hotel_Booking_PPY3\public\storage] link has been connected to [D:\Hotel_Booking_PPY3\storage\app/public].`

### Step 2: Ensure Storage Directories Exist

```bash
mkdir -p storage/app/public/rooms
```

### Step 3: Verify Configuration

- ✅ `config/filesystems.php` - Correctly configured
- ✅ `app/Models/Room.php` - Image field in $fillable
- ✅ `AdminRoomController.php` - Proper image handling
- ✅ View templates - Correct image display URLs

## Testing the Image Upload Feature

### How to Test:

1. **Go to Admin Dashboard**
    - Navigate to: `http://localhost:8000/admin/rooms`

2. **Create a New Room with Image**
    - Click "Add Room" button
    - Fill in room details:
        - **Number**: 101
        - **Type**: Deluxe
        - **Price**: 150.00
        - **Capacity**: 2
        - **Features**: WiFi, AC, TV
        - **Description**: A beautiful deluxe room
        - **Image**: Select a JPG/PNG file (max 2MB)
    - Click "Create Room"

3. **Verify Image Display**
    - Admin should see image thumbnail in rooms list
    - Image URL should be: `/storage/rooms/filename.jpg`
    - No 404 errors should appear

4. **Edit Room Image**
    - Click "Edit" on a room
    - Current image is shown with option to replace
    - Upload new image and save
    - Old image is automatically deleted

5. **Delete Room**
    - Click "Delete" on a room
    - Image file is automatically deleted from storage

6. **View in Customer Interface**
    - Go to: `http://localhost:8000/`
    - Room images should display on the customer rooms page
    - Click on room to see full image in detail view

## Important Notes

### File Size Limits

- Maximum image size: **2MB** (configurable in controller)
- Allowed formats: **JPEG, PNG, GIF**
- Modify in `AdminRoomController.php` validation rules:
    ```php
    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ```

### Symlink on Different Environments

**Development (Windows - Already Done):**

```bash
php artisan storage:link
```

**Production Deployment (Linux/Ubuntu):**

```bash
php artisan storage:link
```

**If Symlink Fails on Windows:**

```powershell
# Run as Administrator
New-Item -ItemType SymbolicLink -Path "public\storage" -Target "storage\app\public"
```

### File Paths Stored in Database

When you upload an image, the database stores the relative path:

```
Example: rooms/3XmK9vL2mN5pQ7rTuVwXyZ.jpg
         │     │
         │     └─ Filename (auto-generated)
         └─────── Directory in storage/app/public/
```

### Storage Directory Permissions

Ensure proper permissions:

```bash
chmod -R 775 storage/app/public
chmod -R 775 storage/logs
```

## Troubleshooting

### Still Getting 404 Error?

1. **Check symlink exists:**

    ```bash
    php artisan storage:link
    ls -la public/storage  # Should show symlink arrow
    ```

2. **Check file was uploaded:**

    ```bash
    ls -la storage/app/public/rooms/
    ```

3. **Verify database entry:**
    - Open database GUI or run:

    ```bash
    sqlite3 database/database.sqlite "SELECT id, number, image FROM rooms;"
    ```

4. **Clear Laravel cache:**
    ```bash
    php artisan cache:clear
    php artisan config:clear
    ```

### Symlink Broken After Moving Project?

```bash
# Remove old symlink
rm public/storage
# Recreate symlink
php artisan storage:link
```

## Complete CRUD Operation Flow

### CREATE (Admin Creates New Room with Image)

```
Form Submit → AdminRoomController::store()
    ↓
Validate: image is image, max 2MB
    ↓
Store image: storage('rooms', 'public')
    ↓
Save path to Room model → database
    ↓
Redirect with success message → rooms list
    ↓
Display as: /storage/rooms/filename.jpg
```

### READ (Display Images)

```
Admin/Customer views image
    ↓
Blade template: {{ asset('storage/' . $room->image) }}
    ↓
URL: /storage/rooms/filename.jpg
    ↓
Symlink resolves to: storage/app/public/rooms/filename.jpg
    ↓
File served to client
```

### UPDATE (Admin Updates Room Image)

```
Edit form shows current image
    ↓
Upload new image
    ↓
AdminRoomController::update()
    ↓
Check if new image provided
    ↓
Delete old image from storage
    ↓
Store new image: storage('rooms', 'public')
    ↓
Update database path
    ↓
Display new image
```

### DELETE (Admin Deletes Room)

```
Delete confirmation click
    ↓
AdminRoomController::destroy()
    ↓
Check if image exists
    ↓
Delete image file from storage
    ↓
Delete room record from database
    ↓
Redirect to rooms list (image gone)
```

## Summary

Your image upload functionality is now **fully operational**! The issue was the missing storage symlink, which has been created. Your application now has:

✅ Image upload in admin interface  
✅ Image display on admin rooms list  
✅ Image display in customer interface  
✅ Image update when editing rooms  
✅ Automatic image deletion when removing rooms  
✅ Proper error handling and validation

**You can now upload, view, edit, and delete room images without any 404 errors!**
