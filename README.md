# ShoesStore

## Cách Setup Project

1. **Tải XAMPP**  
   [Download XAMPP](https://www.apachefriends.org/download.html)

2. **Tải Composer**  
   [Download Composer](https://getcomposer.org/)

3. **Cấu hình XAMPP**  
   - Mở XAMPP, bật Apache, bật MySQL rồi bấm **Config** → **PHP (php.ini)** ở cùng dòng với MySQL

4. **Kích hoạt extension zip**  
   - Tìm từ khóa `zip` (Ctrl + F)  
   - Bỏ dấu “;” trong dòng `;extension=zip` để kích hoạt:
     ```ini
     extension=zip
     ```

5. **Lưu và đóng file php.ini**

6. **Di chuyển dự án vào thư mục Htdocs**  
   - Lưu ý: Chỉ copy **nội dung bên trong** thư mục ShoesStore, không copy cả thư mục gốc

7. **Mở dự án bằng VSCode**  
   - Chạy **Apache** và **MySQL** trên XAMPP

8. **Chạy các file SQL**  
   - Vào thư mục **sql** và chạy lần lượt các file **init.sql** và **insert.sql**

9. **Truy cập dự án**  
   - Địa chỉ: `localhost/frontend/index.php`

> **Lưu ý:**  
> TUYỆT ĐỐI KHÔNG copy cả thư mục ShoesStore vào Htdocs. Chỉ copy nội dung bên trong thư muụ ShoesStore để tránh lỗi URL.
> Đồ án có tích hợp Chatbot sử dụng [OpenRouter](https://openrouter.ai/), nếu muốn sử dụng phải cung cấp 1 API key.

10. **Cách thêm API Key Chatbot vào đồ án**
   - Tạo 1 file .env ở thư mục root
   - Đặt tên biến là OPENROUTER_API_KEY="Nhập API key vào đây"
   - Hiện tại chỉ có chức năng chat với bot và tạo phiên chat mới. Các tính năng khác liên quan đến AI sẽ bổ sung sau.
   - Có thể đổi model ở file DeepSeekService.php
    $data = [
                'model' => 'deepseek/deepseek-chat-v3.1:free',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 1000,
                'stream' => false
            ];
	'model' => 'deepseek/deepseek-chat-v3.1:free' có thể xài model tính phí hay miễn phí đều được, những API phải lấy từ OpenRouter.