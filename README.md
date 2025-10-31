
**Lưu ý quan trọng:** đây là file README.md duy nhất, hoàn chỉnh nhất để hướng dẫn bạn, và chắc chắn sẽ chạy được dự án ở môi trường macOS. 
Vui lòng không đọc các file .md khác, trừ một số file hướng dẫn làm thế nào để thực thi/ làm challenge, nếu không **sẽ bị mù mắt!**

Sẽ có một số giai đoạn khi deploy ở môi trường local, sẽ có các error nhỏ, như lỗi connection error, lỗi port đã được sử dụng, lỗi docker không khởi động được,...
vui lòng đọc kỹ phần Troubleshooting ở cuối file README.md này để khắc phục các lỗi thường gặp.

Trang web truy cập (khi máy chủ đã khởi chạy, bởi vì đang chạy thông qua cloudflare tunnel):
- https://ctf.vinhhaphoi.com/
- https://vuln.vinhhaphoi.com/

Nếu có thắc mắc, vui lòng liên hệ:
- **Support email:** support@vinhhaphoi.click

Trân trọng!


# Database Security CTF Lab

Một môi trường CTF (Capture The Flag) được thiết kế để học và thực hành Database Penetration Testing với MySQL.

## 📋 Tổng Quan

Dự án này bao gồm:
- **MySQL Database** với các lỗ hổng bảo mật được thiết kế
- **Vulnerable Web Application** (PHP) để khai thác SQL Injection
- **CTF Platform** (Python Flask) để submit flags và theo dõi tiến độ
- **10 Challenges** theo đúng quy trình Penetration Testing

## 🎯 Mục Tiêu Học Tập

1. Hiểu về các lỗ hổng Database Security phổ biến
2. Thực hành Penetration Testing theo chuẩn quy trình
3. Sử dụng công cụ AI trong Security Testing
4. Phát triển kỹ năng SQL Injection và Post-Exploitation

## 🛠️ Yêu Cầu Hệ Thống

### Windows (not recommended):
- Windows 10/11
- Docker Desktop for Windows (với WSL2)
- 4GB RAM trở lên
- 10GB ổ cứng trống

### macOS (highly recommended):
- macOS Sequoia trở lên
- Docker Desktop for Mac

### Công cụ Pentesting (Tùy chọn):
- nmap
- sqlmap
- Burp Suite Community
- MySQL Client
- Python với requests library

## 🚀 Hướng Dẫn Cài Đặt

### Bước 1: Clone hoặc Download Project

```bash
cd C:\Users\noter
git clone https://github.com/vinhhaphoi/ctf-platform
cd database-security-ctf
```

### Bước 2: Cài Đặt Docker Desktop

1. Download Docker Desktop từ: https://www.docker.com/products/docker-desktop
2. Cài đặt và khởi động Docker Desktop
3. Đảm bảo Docker đang chạy (kiểm tra system tray)

### Bước 3: Chạy Setup Script

**Trên macOS:**
```cmd
cd /path/to/database-security-ctf
cd generate-flags
python3 generate_flags.py
```
Sau khi chạy xong, quay lại thư mục gốc, mở file .env để lấy credentials.:
```bash
cat .env
```
Lấy password từ biến `MYSQL_PASSWORD` và `CTF_ADMIN_PASSWORD`, đưa vào ctf-platform/app.py để đăng nhập admin

Sau đó, build và chạy Docker containers:
```bash
docker-compose up -d --build
```

Để tắt containers:
```bash
docker-compose down -v
```
### Bước 4: Truy Cập Các Services

Sau khi setup hoàn tất:

- **CTF Platform:** http://localhost:5050
- **Vulnerable Web App:** http://localhost:8080
- **MySQL Database:** `localhost:3306`

## 📚 Cấu Trúc Project

```
database-security-ctf/
├── docker-compose.yml          # Docker orchestration
├── setup.bat                   # Windows setup script
├── .env                        # Environment variables (auto-generated)
├── flags.json                  # Generated flags (auto-generated)
│
├── flag-generator/             # Flag generation system
│   └── generate_flags.py       # Python script to generate unique flags
│
├── mysql/                      # MySQL Database container
│   ├── Dockerfile
│   ├── my.cnf                  # MySQL configuration (intentionally weak)
│   └── init/
│       ├── 01-schema.sql       # Database schema
│       └── 02-flags.sql        # Flags injection (auto-generated)
│
├── vulnerable-web/             # Vulnerable PHP Application
│   ├── Dockerfile
│   └── app/
│       ├── index.php           # Main entry point
│       ├── config.php          # Configuration
│       ├── db.php              # Database functions (vulnerable)
│       ├── style.css           # Styling
│       └── pages/              # Application pages
│           ├── home.php
│           ├── login.php
│           ├── products.php
│           ├── search.php
│           └── admin.php
│
└── ctf-platform/               # CTF Platform (Flask)
    ├── Dockerfile
    ├── requirements.txt
    ├── app.py                  # Main Flask application
    ├── templates/              # HTML templates
    │   ├── base.html
    │   ├── index.html
    │   ├── challenge.html
    │   ├── scoreboard.html
    │   └── about.html
    └── static/                 # Static files
        ├── css/style.css
        └── js/main.js
```

## 🎮 Cách Chơi

### 1. Truy cập CTF Platform

Mở trình duyệt và truy cập: http://localhost:5050

### 2. Chọn Challenge

10 challenges được chia thành 4 categories:
- **Reconnaissance** (2 challenges)
- **Enumeration** (2 challenges)
- **Exploitation** (3 challenges)
- **Post-Exploitation** (3 challenges)

### 3. Thực Hiện Pentesting

Sử dụng các công cụ để tấn công:
- Target web: http://localhost:8080
- MySQL: `mysql -h localhost -P 3306 -u ctf_user -p`

### 4. Tìm Flags

Mỗi challenge có flag theo format: `FLAG{hash_string}`

### 5. Submit Flags

Submit flags vào CTF Platform để ghi điểm

## 🔍 Danh Sách Challenges

### Challenge 1: Database Fingerprinting (100 pts)
**Category:** Reconnaissance
**Objective:** Xác định loại database và version
**Hint:** Sử dụng nmap hoặc kết nối trực tiếp MySQL

### Challenge 2: Service Enumeration (100 pts)
**Category:** Reconnaissance
**Objective:** Liệt kê các services đang chạy
**Hint:** Check system_info table

### Challenge 3: Database Schema Discovery (150 pts)
**Category:** Enumeration
**Objective:** Tìm hidden databases
**Hint:** SHOW DATABASES

### Challenge 4: User Enumeration (150 pts)
**Category:** Enumeration
**Objective:** Tìm MySQL users
**Hint:** mysql.user table

### Challenge 5: SQL Injection - Authentication Bypass (200 pts)
**Category:** Exploitation
**Objective:** Bypass admin login
**Hint:** ' OR '1'='1' --

### Challenge 6: Blind SQL Injection (250 pts)
**Category:** Exploitation
**Objective:** Extract hidden data
**Hint:** UNION-based injection

### Challenge 7: Local File Read (250 pts)
**Category:** Exploitation
**Objective:** Đọc files từ server
**Hint:** LOAD_FILE() function

### Challenge 8: Privilege Escalation (300 pts)
**Category:** Post-Exploitation
**Objective:** Access admin procedures
**Hint:** SHOW PROCEDURE STATUS

### Challenge 9: Backdoor Detection (200 pts)
**Category:** Post-Exploitation
**Objective:** Tìm backdoor trigger
**Hint:** SHOW TRIGGERS

### Challenge 10: Log Analysis (150 pts)
**Category:** Post-Exploitation
**Objective:** Phân tích logs
**Hint:** audit_log table

## 🤖 Tích Hợp AI Tools

### Sử dụng ChatGPT/Claude:

1. **Phân tích Error Messages:**
```
Prompt: "Analyze this SQL error and suggest exploitation: [error_message]"
```

2. **Generate SQLi Payloads:**
```
Prompt: "Generate SQL injection payloads for MySQL authentication bypass"
```

3. **Blind SQLi Optimization:**
```
Prompt: "Optimize this blind SQL injection script for faster extraction"
```

### Python Script với OpenAI API:

```python
import openai

def generate_payload(context):
    response = openai.ChatCompletion.create(
        model="gpt-4",
        messages=[{
            "role": "user",
            "content": f"Generate SQLi payload: {context}"
        }]
    )
    return response.choices[0].message.content
```

## 🔧 Quản Lý Containers

### Start cloudflare tunnel:
```bash
cloudflared tunnel run ctf-platform-tunnel
```

### Xem logs:
```bash
docker-compose logs -f
docker-compose logs mysql
docker-compose logs vulnerable-web
docker-compose logs ctf-platform
```

### Stop containers:
```bash
docker-compose down
```

### Restart containers:
```bash
docker-compose restart
```

### Rebuild sau khi thay đổi code:
```bash
docker-compose down
docker-compose build
docker-compose up -d
```

### Xem container status:
```bash
docker-compose ps
```

### Truy cập MySQL shell:
```bash
docker exec -it ctf-mysql mysql -u root -p
# Password: check .env file MYSQL_ROOT_PASSWORD
```

## 📝 Database Credentials

Check file `.env` (được tạo tự động) để lấy credentials:

```
MYSQL_ROOT_PASSWORD=<random>
MYSQL_DATABASE=ctf_database
MYSQL_USER=ctf_user
MYSQL_PASSWORD=<random>
WEB_SESSION_SECRET=<random> - nằm trong vulnerable-web/config.php
CTF_ADMIN_PASSWORD=<random> - dùng để đăng nhập CTF Platform
```

### Connect MySQL từ máy local:

```bash
mysql -h localhost -P 3306 -u ctf_user -p
# Enter password from .env
```

## 🛡️ Quy Trình Pentesting Đề Xuất

### Phase 1: Reconnaissance
```bash
# Port scan
nmap -sV -p- localhost

# Banner grab
nc localhost 3306
```

### Phase 2: Enumeration
```bash
# Connect to MySQL
mysql -h localhost -P 3306 -u ctf_user -p

# Enumerate databases
SHOW DATABASES;

# Enumerate tables
USE ctf_database;
SHOW TABLES;
```

### Phase 3: Exploitation
```bash
# SQLMap automated scan
sqlmap -u "http://localhost:8080/index.php?page=login" \
       --data="username=admin&password=test" \
       --dbs

# Manual SQLi testing
# Try: admin' OR '1'='1' --
```

### Phase 4: Post-Exploitation
```sql
-- Check stored procedures
SHOW PROCEDURE STATUS WHERE Db = 'ctf_database';

-- Check triggers
SHOW TRIGGERS FROM ctf_database;

-- Read logs
SELECT * FROM audit_log;
```

## ⚠️ Lưu Ý Quan Trọng

### Security Warnings:

1. **CHỈ SỬ DỤNG CHO HỌC TẬP**
   - Môi trường này có lỗ hổng bảo mật nghiêm trọng
   - KHÔNG deploy lên môi trường production
   - KHÔNG expose ra public network

2. **Docker Ports:**
   - Các ports chỉ bind trên localhost
   - Nếu cần test từ máy khác, cấu hình firewall cẩn thận

3. **Passwords:**
   - File `.env` chứa passwords ngẫu nhiên
   - Không commit `.env` vào Git
   - Mỗi lần chạy setup.bat sẽ tạo passwords mới

### Troubleshooting:

**Problem:** Docker không start
```
Solution:
1. Kiểm tra Docker Desktop đang chạy
2. Restart Docker Desktop
3. Check: docker info
```

**Problem:** Port đã được sử dụng
```
Solution:
1. Stop các services đang dùng port 3306, 5000, 8080
2. Hoặc sửa ports trong docker-compose.yml
3. Vào `docker-compose.yml`, thay đổi đoạn code sau:
    Từ:
    services:
    # MySQL Database with intentional vulnerabilities
    mysql:
        image: mysql:8.0
        container_name: ctf-mysql
        environment:
        MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
        MYSQL_DATABASE: ${MYSQL_DATABASE}
        MYSQL_USER: ${MYSQL_USER}
        MYSQL_PASSWORD: ${MYSQL_PASSWORD}
        # MYSQL_TCP_PORT: 3308

    Thành:
    services:
    # MySQL Database with intentional vulnerabilities
    mysql:
        image: mysql:8.0
        container_name: ctf-mysql
        environment:
        MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
        MYSQL_DATABASE: ${MYSQL_DATABASE}
        MYSQL_USER: ${MYSQL_USER}
        MYSQL_PASSWORD: ${MYSQL_PASSWORD}
        MYSQL_TCP_PORT: 3308 # uncommend đoạn này nhằm sử dụng port 3308 thay vì 3306
        có thể một vài máy bị xung đột port 3306
```

Solution:
1. Check logs: docker-compose logs mysql
2. Wait thêm vài giây cho MySQL khởi động
3. Verify: docker-compose ps
```

**Problem:** Flags không được generate
```
Solution:
1. cd flag-generator
2. python generate_flags.py
3. Check file flags.json được tạo
```

## 🎓 Dành Cho Giảng Viên

### Tùy Chỉnh Challenges:

Edit file `ctf-platform/app.py` để thay đổi:
- Số điểm của challenges
- Mô tả challenges
- Hints

### Reset Environment:

```bash
docker-compose down -v
python flag-generator/generate_flags.py
docker-compose up -d
```

### Xem Progress của Students:

Access CTF Platform và check scoreboard

## 📖 Tài Liệu Tham Khảo

- [OWASP SQL Injection](https://owasp.org/www-community/attacks/SQL_Injection)
- [PortSwigger SQL Injection](https://portswigger.net/web-security/sql-injection)
- [MySQL Security Best Practices](https://dev.mysql.com/doc/refman/8.0/en/security.html)
- [sqlmap Documentation](https://github.com/sqlmapproject/sqlmap/wiki)

## 📄 License

MIT License - For Educational Use Only

## 🤝 Đóng Góp

Nếu tìm thấy bugs hoặc có suggestions:
1. Tạo Issue
2. Submit Pull Request
3. Contact: (mailto:)[support@vinhhaphoi.click]

---

**Have fun hacking! 🚀**

Remember: Always hack ethically and legally! 🛡️


