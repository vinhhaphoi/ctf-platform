# Database Security CTF Lab - Student Manual

## Chào Mừng Đến Với CTF Lab! 🎯

Bạn sắp tham gia một cuộc thi Capture The Flag (CTF) về Database Security. Mục tiêu là tìm 10 flags ẩn trong hệ thống bằng cách khai thác các lỗ hổng bảo mật.

**Thời gian:** 4-5 giờ
**Điểm:** 2000 points
**Challenges:** 10 challenges

---

## 📋 Mục Tiêu Học Tập

Sau khi hoàn thành lab này, bạn sẽ:
- ✅ Hiểu quy trình penetration testing chuẩn
- ✅ Thực hành SQL injection techniques
- ✅ Phát hiện database misconfigurations
- ✅ Khai thác privilege escalation vulnerabilities
- ✅ Sử dụng AI tools trong security testing
- ✅ Viết professional penetration test report

---

## 🚀 Quick Start

### Bước 1: Truy Cập CTF Platform

Mở browser và vào: `http://localhost:5000`

Bạn sẽ thấy 10 challenges được chia thành 5 phases:
- **Phase 1:** Reconnaissance (2 challenges)
- **Phase 2:** Misconfiguration Discovery (3 challenges)
- **Phase 3:** Privilege Escalation (2 challenges)
- **Phase 4:** Injection Attacks (2 challenges)
- **Phase 5:** Key Extraction (1 challenge)

### Bước 2: Bắt Đầu Với Challenge 1

Click vào "Challenge 1: Network Scanning & Port Discovery"

Bạn sẽ thấy:
- 📋 **Description** - Nhiệm vụ cần làm
- 🎯 **Learning Objectives** - Bạn sẽ học được gì
- 🛠️ **Recommended Tools** - Tools nên dùng
- 🤖 **AI Integration Tip** - Cách AI có thể giúp
- 💡 **Hints** - Gợi ý (click "Show Hints")

### Bước 3: Pentest!

Sử dụng tools và kỹ năng của bạn để tìm flag.

**Targets:**
- CTF Platform: `http://localhost:5000`
- Vulnerable Web: `http://localhost:8080`
- MySQL Database: `localhost:3306`

### Bước 4: Submit Flag

Khi tìm được flag (format: `FLAG{...}`), submit vào form.

Nếu đúng → +points, chuyển sang challenge tiếp theo!

---

## 🎓 Pentest Workflow - Làm Theo Thứ Tự Này!

### Phase 1: RECONNAISSANCE (30 phút)
**Mục đích:** Thu thập thông tin về target

📍 **Challenge 1:** Network Scanning
- Scan ports với nmap
- Identify MySQL service
- Get version information

📍 **Challenge 2:** Banner Grabbing
- Connect MySQL client
- Extract database version
- Find flag in system tables

**Skills học được:**
- Network scanning
- Service fingerprinting
- Information gathering

---

### Phase 2: MISCONFIGURATION DISCOVERY (45 phút)
**Mục đích:** Tìm cấu hình yếu và lỗi setup

📍 **Challenge 3:** Weak Credentials
- Test common passwords
- Try default credentials
- Find users with weak passwords

📍 **Challenge 4:** Excessive Privileges
- Audit user permissions
- Find dangerous privileges (FILE, SUPER)
- Understand least privilege principle

📍 **Challenge 5:** Insecure Configuration
- Check MySQL variables
- Identify misconfigurations
- Use AI config auditor tool

**Skills học được:**
- Configuration auditing
- Privilege enumeration
- Password attack techniques

---

### Phase 3: PRIVILEGE ESCALATION (1 giờ)
**Mục đích:** Leo thang quyền hạn để access dữ liệu nhạy cảm

📍 **Challenge 6:** Horizontal Privilege Escalation
- Access other users' data
- Exploit IDOR vulnerability
- Bypass access controls

📍 **Challenge 7:** Vertical Privilege Escalation
- Find stored procedures
- Exploit DEFINER privileges
- Gain admin access

**Skills học được:**
- Horizontal vs vertical escalation
- IDOR exploitation
- Stored procedure security

---

### Phase 4: INJECTION ATTACKS (1.5 giờ)
**Mục đích:** Khai thác SQL injection vulnerabilities

📍 **Challenge 8:** Authentication Bypass
- Bypass login form
- Classic SQL injection
- Access admin panel

📍 **Challenge 9:** Blind SQL Injection
- Extract hidden data
- Boolean-based techniques
- Use AI optimization tool

**Skills học được:**
- SQL injection techniques
- Authentication bypass
- Blind SQLi automation

---

### Phase 5: KEY EXTRACTION (45 phút)
**Mục đích:** Tổng hợp tất cả kỹ năng để giải master challenge

📍 **Challenge 10:** Master Key Extraction
- Combine all learned techniques
- Extract key from 3 locations
- Reconstruct master flag

**Skills học được:**
- Multi-stage attacks
- Data correlation
- Using all previous techniques together

---

## 🛠️ Tools & Resources

### Required Tools (Đã Cài Sẵn)
- MySQL Client
- Web Browser
- Command Line/Terminal

### Recommended Tools
- **nmap** - Network scanner
- **Burp Suite Community** - Web proxy
- **sqlmap** - SQL injection automation

### AI Helper Tools (NEW!)
Trong folder `ai-helpers/`:

1. **wordlist_generator.py** - Generate password lists
2. **blind_sqli_optimizer.py** - Optimize blind SQLi
3. **config_auditor.py** - Audit MySQL config
4. **log_analyzer.py** - Analyze logs

**Cách dùng:**
```bash
cd ai-helpers
python config_auditor.py --user ctf_user --password <from .env>
```

---

## 🤖 Sử Dụng AI Hiệu Quả

### Khi Nào Nên Dùng AI?

**✅ Nên dùng AI khi:**
- Cần generate payloads nhanh
- Phân tích error messages
- Audit configuration files
- Optimize blind SQLi
- Explain technical concepts

**❌ Không nên dùng AI cho:**
- Thay thế việc hiểu concepts
- Copy-paste code không hiểu
- Skip manual analysis
- Tất cả challenges (phải tự làm một số!)

### Example AI Prompts

**Khi stuck ở Challenge:**
```
"I'm doing a penetration test and found this MySQL error:
[error message here]
What SQL injection technique could exploit this?"
```

**Khi cần hiểu vulnerability:**
```
"Explain what DEFINER privilege means in MySQL stored procedures
and how it can be exploited for privilege escalation"
```

**Khi optimize script:**
```
"Optimize this blind SQL injection script to guess characters
faster using frequency analysis"
```

---

## 📝 Document Your Work!

### Ghi Chép Mỗi Challenge

Tạo file notes cho mỗi challenge:

```
Challenge X: [Title]
-------------------
Start time: [time]
End time: [time]

Steps:
1. [What you did]
2. [Command used]
3. [Result]

Flag found: FLAG{...}
Screenshots: [saved where]

What I learned:
- [key takeaway 1]
- [key takeaway 2]
```

### Screenshots Quan Trọng

Chụp màn hình:
- ✅ Successful exploits
- ✅ Flag found locations
- ✅ Key commands and outputs
- ✅ Interesting errors

---

## ⚠️ Common Mistakes - Tránh Những Lỗi Này!

### 1. Không Đọc Hints
**Problem:** Stuck 1 giờ vì không click "Show Hints"
**Solution:** Đọc hints trước khi stuck quá lâu!

### 2. Skip Phases
**Problem:** Nhảy thẳng vào Challenge 10 mà chưa làm 1-9
**Solution:** Làm theo thứ tự! Mỗi phase builds on phase trước.

### 3. Quên .env File
**Problem:** Không connect được MySQL
**Solution:** Check file `.env` để lấy password

### 4. Syntax Errors
**Problem:** SQL queries fail
**Solution:**
- Nhớ dấu `;` ở cuối SQL
- Nhớ `--` để comment
- Check quotes: `'` vs `"`

### 5. Wrong Tables
**Problem:** Query sai table
**Solution:** Dùng `SHOW TABLES;` để list tất cả tables

### 6. Không Document
**Problem:** Tìm được flag nhưng quên cách làm
**Solution:** Ghi lại NGAY mỗi bước!

### 7. Quá Phức Tạp
**Problem:** Dùng advanced techniques cho simple challenge
**Solution:** Start simple! Thử cách đơn giản trước.

---

## 🎯 Strategies For Success

### Time Management
- Phase 1: 30 min (không nên quá 45 min)
- Phase 2: 45 min (không nên quá 1 giờ)
- Phase 3: 1 giờ (không nên quá 1.5 giờ)
- Phase 4: 1.5 giờ (không nên quá 2 giờ)
- Phase 5: 45 min (có thể lâu hơn nếu cần)

### When Stuck (>30 min on one challenge)
1. ✅ Read ALL hints
2. ✅ Google the concept
3. ✅ Ask AI for explanation (not solution!)
4. ✅ Try AI helper tools
5. ✅ Ask instructor
6. ⏭️ Move to next challenge, come back later

### Use AI Wisely
- **DON'T:** "Give me the solution to Challenge X"
- **DO:** "Explain how blind SQL injection works"
- **DON'T:** Copy-paste without understanding
- **DO:** Use AI to learn and optimize

---

## 📊 Grading Criteria

### Flags (40%)
- Each correct flag: 4%
- Total 10 flags: 40%

### Process & Methodology (20%)
- Followed pentest phases: 10%
- Used appropriate tools: 5%
- Documented steps: 5%

### AI Integration (15%)
- Used AI tools effectively: 10%
- Can explain AI outputs: 5%

### Final Report (15%)
- Clear findings: 5%
- Screenshots/evidence: 5%
- Professional format: 5%

### Time & Efficiency (10%)
- Completed in time: 10%

**Bonus:** +10% for finding unintended solutions!

---

## 📄 Final Report Template

### Executive Summary
- Tổng quan về lab
- Số challenges hoàn thành
- Key findings

### Methodology
- Quy trình pentest đã follow
- Tools đã sử dụng
- AI integration approach

### Findings by Phase
For each challenge:
- Challenge name & category
- Vulnerability found
- Exploitation steps (với screenshots)
- Flag obtained
- Lesson learned

### AI Usage Analysis
- Which AI tools used
- How AI helped
- Limitations encountered

### Recommendations
- Làm sao fix các vulnerabilities found
- Security best practices
- Lessons for future projects

### Appendix
- All commands used
- All screenshots
- Tools reference

**Length:** 10-15 pages
**Format:** PDF preferred
**Due:** [Instructor will specify]

---

## 🆘 Getting Help

### Resources
1. **Hints** - Click "Show Hints" in each challenge
2. **AI Tools** - Use the helper scripts
3. **Google** - Real pentesters Google!
4. **CTF Platform** - Check learning objectives
5. **Instructor** - Ask when really stuck

### Questions to Ask Yourself
- ❓ Did I read all the hints?
- ❓ Did I check the learning objectives?
- ❓ Did I try the recommended tools?
- ❓ Did I use AI tools?
- ❓ Did I Google the concept?
- ❓ Am I on the right phase?

### When to Ask Instructor
- ✅ After trying for 30+ minutes
- ✅ After reading all hints
- ✅ When Docker/MySQL not working
- ✅ Conceptual questions
- ❌ "Give me the answer"
- ❌ Without trying first

---

## 🎉 Completion Checklist

Before submitting, verify:

- [ ] Completed all 10 challenges
- [ ] Found and submitted all 10 flags
- [ ] Documented each challenge with screenshots
- [ ] Used at least 2 AI tools
- [ ] Wrote final report
- [ ] Explained what you learned
- [ ] Checked report for completeness
- [ ] Saved all screenshots and notes
- [ ] Ready to present findings!

---

## 💡 Final Tips

### Do's ✅
- Start early, don't rush
- Follow the phases in order
- Document everything
- Use AI as learning tool
- Ask questions
- Have fun hacking!

### Don'ts ❌
- Don't skip challenges
- Don't copy without understanding
- Don't give up too early
- Don't forget to save work
- Don't hack real systems (only this lab!)

---

## 🏆 Good Luck!

Remember:
- **This is a learning experience**
- **Mistakes are okay**
- **AI is a tool, not a replacement**
- **The journey matters, not just the flags**

**Have fun and happy hacking! 🚀🎯**

---

*Questions? Check TESTING_GUIDE.md or ask your instructor.*

*Need AI help? See AI_USAGE_GUIDE.md*

*Want tools setup? See TOOLS_SETUP.md*
