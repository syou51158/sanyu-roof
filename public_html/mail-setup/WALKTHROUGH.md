# Sanyu Roof Email Configuration Portal Walkthrough

I have successfully created a secure, premium-designed email configuration portal for Sanyu Roof.

## 📂 New Files
- **`public_html/mail-setup/index.php`**: The main access point. Features a password-protected login and a dual-tab interface for iOS automation and manual settings.
- **`public_html/mail-setup/download.php`**: A backend script that generates valid `.mobileconfig` files for iPhone/iPad auto-setup.
- **`public_html/mail-setup/assets/style.css`**: Custom CSS ensuring a professional, mobile-responsive design that matches the "Premium" aesthetic.

## 🔐 Access Details
- **URL**: `https://sanyu-roof.jp/mail-setup/` (After deployment)
- **Shared Password**: `Q1P6vmobngEVdJWZ--` (Hardcoded in `index.php`, can be changed easily)

## 📱 Features
### 1. iOS Auto-Setup (iPhone/iPad)
Users can simply enter their Name, Email, and Password to download a configuration profile.
**Note**: Since the profile is generated dynamically and unsigned, users will see a "Not Verified" warning during installation on their iPhone. This is standard for self-hosted profiles and is safe to proceed.

### 2. Manual Settings (Android/PC)
A clear, organized display of:
- **IMAP (Incoming)**: `imap.lolipop.jp` (Port 993, SSL)
- **SMTP (Outgoing)**: `smtp.lolipop.jp` (Port 465, SSL)

## 🚀 How to Deploy
1.  Upload the `mail-setup` folder to your `public_html` directory on the server.
2.  That's it! Access it via the browser.

## 📸 Screenshots (Mockup)
*(Since I cannot take screenshots of the running PHP server, here is a text representation)*

**Login Screen:**
> **Sanyu Roof Mail Configuration Portal**
>
> 🔒 Locked
> [ Password Field ]
> [ ログイン Button ]

**Dashboard:**
> **[ iPhone設定 ]** [ 手動設定 ]
>
> **一括設定プロファイル**
> Enter details to download...
>
> Name: [ _______ ]
> Email: [ info@sanyu-roof.jp ]
> Password: [ _______ ]
>
> [ ⬇️ Download Profile ]
>
> *⚠️ Note: Go to Settings > Profile Downloaded to install.*

## 👤 Generated Credential
**Account**: `yu-ma.yamamoto@sanyu-roof.jp`
**Password**: `Q1P6vmobngEVdJWZ`
**Access URL**: `/mail-setup/`
