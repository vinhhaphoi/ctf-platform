# Testing Guide - Redesigned CTF Lab

## Quick Test Checklist

### 1. Test Flag Generator
```bash
cd flag-generator
python generate_flags.py
```

**Expected Output:**
- ✅ 10 flags generated (grouped by 5 phases)
- ✅ `flags.json` created in parent directory
- ✅ `02-flags.sql` created in `mysql/init/`
- ✅ `.env` file created with random passwords

---

### 2. Test Docker Build
```bash
docker-compose build
```

**Expected:**
- ✅ 3 images build successfully: mysql, vulnerable-web, ctf-platform
- ⚠️ May see warnings about schema - this is OK for now

---

### 3. Test Docker Start
```bash
docker-compose up -d
docker-compose logs -f
```

**Expected:**
- ✅ All 3 containers running
- ✅ MySQL initializes with 01-schema.sql and 02-flags.sql
- ⚠️ May see SQL errors for missing tables - see fixes below

---

### 4. Test CTF Platform
Open browser: `http://localhost:5050`

**Expected:**
- ✅ See 10 challenges grouped by phase
- ✅ Each challenge shows: phase badge, difficulty, estimated time
- ✅ Click on Challenge 1 → See learning objectives, tools, AI tips
- ✅ Submit wrong flag → "Incorrect" message
- ✅ Submit correct flag from flags.json → Success + points

---

### 5. Test Vulnerable Web App
Open browser: `http://localhost:8080`

**Expected:**
- ✅ Homepage loads
- ✅ Can navigate to products, login pages
- ⚠️ Profile page may 404 (not implemented yet)

---

### 6. Test MySQL Connection
```bash
# Get password from .env file
type .env | findstr MYSQL_PASSWORD

# Connect
mysql -h localhost -P 3306 -u ctf_user -p
# Enter password from above

# Test queries
SHOW DATABASES;
USE ctf_database;
SHOW TABLES;
SELECT * FROM system_info;
```

**Expected:**
- ✅ Can connect with ctf_user
- ✅ Can see ctf_database
- ✅ Tables: system_info, users, products, admin_panel, etc.
- ✅ Flags in system_info table

---

### 7. Test AI Helper Tools
```bash
cd ai-helpers

# Test without API key (fallback mode)
python wordlist_generator.py --fallback --output test.txt

# Test config auditor (requires MySQL running)
python config_auditor.py --user ctf_user --password <from .env>
```

**Expected:**
- ✅ Wordlist generator creates file with passwords
- ✅ Config auditor connects and shows security findings

---

## Known Issues & Quick Fixes

### Issue 1: Missing Tables in 02-flags.sql
**Symptom:** SQL errors like "Table 'user_privileges' doesn't exist"

**Quick Fix:**
```sql
-- Connect to MySQL and run:
USE ctf_database;

CREATE TABLE IF NOT EXISTS user_privileges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    privilege_type VARCHAR(50),
    security_risk TEXT,
    discovery_flag VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS config_audit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    config_name VARCHAR(100),
    config_value TEXT,
    risk_level VARCHAR(20),
    audit_flag VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS user_secrets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    private_data TEXT,
    secret_key VARCHAR(255)
);
```

**Permanent Fix:** Add these to `mysql/init/01-schema.sql` (see next section)

---

### Issue 2: Profile Page Missing
**Symptom:** `http://localhost:8080/index.php?page=profile` shows 404

**Status:** Not yet implemented (Challenge 6)

**Temporary Workaround:** Test Challenge 6 using direct SQL queries:
```sql
SELECT * FROM user_secrets WHERE user_id = 2;
```

---

### Issue 3: Unicode Errors in Flag Generator
**Symptom:** UnicodeEncodeError with ✓ character

**Status:** ✅ FIXED - Changed to [OK]

---

## Manual Challenge Testing

### Challenge 1: Network Scanning
```bash
nmap -sV -p 3306 localhost
mysql -h localhost -P 3306 -u ctf_user -p
# In MySQL:
SELECT * FROM system_info WHERE info_key = 'service_banner';
```

**Expected Flag:** From flags.json, challenge ID 1

---

### Challenge 2: Banner Grabbing
```sql
SELECT VERSION();
SELECT * FROM system_info WHERE info_key = 'db_version';
```

**Expected Flag:** From flags.json, challenge ID 2

---

### Challenge 3: Weak Credentials
```bash
mysql -h localhost -P 3306 -u backup -p
# Password: backup123

# After login:
SELECT * FROM users WHERE welcome_flag IS NOT NULL;
```

**Expected Flag:** From flags.json, challenge ID 3

---

### Challenge 4: Excessive Privileges
```sql
SELECT User, Host, File_priv, Super_priv FROM mysql.user;
SELECT * FROM user_privileges;
```

**Expected Flag:** From flags.json, challenge ID 4

---

### Challenge 5: Config Audit
```sql
SHOW VARIABLES LIKE '%secure_file%';
SELECT * FROM config_audit WHERE risk_level = 'CRITICAL';
```

**Or use AI tool:**
```bash
python ai-helpers/config_auditor.py --user ctf_user --password <from .env>
```

**Expected Flag:** From flags.json, challenge ID 5

---

### Challenge 8: SQL Injection Auth Bypass
Try at: `http://localhost:8080/index.php?page=login`

**Payload:**
- Username: `admin' OR '1'='1' --`
- Password: (anything)

**After bypass:**
```sql
SELECT * FROM admin_panel;
```

**Expected Flag:** From flags.json, challenge ID 8

---

### Challenge 9: Blind SQL Injection
Target: `http://localhost:8080/index.php?page=product_detail&id=1`

**Test payload:**
```
id=1 UNION SELECT 1,2,hidden_flag,4,5,6 FROM products--
```

**Or use sqlmap:**
```bash
sqlmap -u "http://localhost:8080/index.php?page=product_detail&id=1" --dump -T products -C hidden_flag
```

**Expected Flag:** From flags.json, challenge ID 9

---

### Challenge 10: Master Key Extraction
```bash
# Use AI tool:
python ai-helpers/log_analyzer.py --user ctf_user --password <from .env>
```

**Or manual:**
```sql
-- Part 1: File
SELECT * FROM file_references WHERE file_type = 'secret';

-- Part 2: Log
SELECT * FROM audit_log WHERE action = 'master_key_fragment';

-- Part 3: Trigger
SHOW CREATE TRIGGER master_key_trigger;

-- Combine all 3 parts to form FLAG{part1_part2_part3}
```

**Expected Flag:** Reconstructed from 3 parts

---

## Success Metrics

✅ **Ready for Student Testing if:**
- [ ] All containers start without errors
- [ ] All 10 flags can be submitted successfully
- [ ] CTF platform UI shows all new fields
- [ ] At least 2 AI tools work
- [ ] Can complete Challenges 1-5 manually

⚠️ **Needs More Work if:**
- [ ] SQL errors on startup
- [ ] Missing tables prevent flag injection
- [ ] Challenges can't be solved
- [ ] UI shows errors or missing data

---

## Next Steps After Testing

1. ✅ Fix any SQL table issues found
2. ✅ Add missing profile.php page
3. ✅ Create full instructor solutions
4. ✅ Write student lab manual
5. ✅ Update documentation
6. ✅ Pilot with 2-3 students

---

## Quick Commands Reference

```bash
# Start environment
docker-compose up -d

# View logs
docker-compose logs -f
docker-compose logs mysql

# Restart
docker-compose restart

# Stop
docker-compose down

# Rebuild after changes
docker-compose down
docker-compose build
docker-compose up -d

# MySQL access
mysql -h localhost -P 3306 -u ctf_user -p

# Regenerate flags
cd flag-generator && python generate_flags.py
```

---

**Happy Testing! 🎯**
