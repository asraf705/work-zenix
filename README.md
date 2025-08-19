#  WorkZenix – SaaS ERP & Work Management Platform

WorkZenix is a **next-generation SaaS-based ERP and Work Management System** built with **Laravel + React**.  
It is designed to empower businesses with **Finance, HR, Project Management, CRM, POS, Inventory, and AI-powered features** – all in one platform.

---

##  Features

###  Core Modules
- **User & Role Management** – Multi-tenant support, custom roles, permissions.
- **Project Management** – Tasks, deadlines, budgets, Gantt charts, Kanban boards.
- **Finance & Accounting**  
  - Payslip  
  - Invoice (Taka & USD formats)  
  - Receipt, Estimate, Quotation, Work Order  
  - Refund, Musok 6.3, Chalan  
  - Account Book (budget, hold/clear amounts, client details)  
  - Cash Flow Book (multi-bank account tracking)  
  - KPI Charts  
  - Assets Management  
- **HR Module** – Attendance, Payroll, Leave Management, Performance tracking.
- **CRM** – Client Management, Lead Tracking, Outreach Automation.
- **POS/Inventory** – Sales, Purchase, Stock Management.
- **Team Communication** – Chat, Notifications, Calendar.
- **AI Assistant** – Contextual suggestions, automated reporting.

---

##  Tech Stack

- **Backend**: Laravel 12 (PHP 8+)
- **Frontend**: React + Vite + TailwindCSS + MUI
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Breeze + Google 2FA
- **Realtime**: Laravel Echo + WebSockets
- **Deployment**: Docker / Nginx / CI/CD (GitHub Actions)

---

##  Project Structure

```

WorkZenix/
│── backend/              # Laravel (API + Business Logic)
│── frontend/             # React (UI)
│── database/             # SQL Migrations & Seeds
│── docs/                 # Documentation & API Specs
│── .env.example          # Environment variables template
│── docker-compose.yml    # Docker setup
│── README.md             # Project documentation

````

---

## Installation

### Clone Repository
```bash
git clone https://github.com/yourusername/workzenix.git
cd workzenix
````

### Backend Setup (Laravel)

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### Frontend Setup (React)

```bash
cd frontend
npm install
npm run dev
```

### Run with Docker (Optional)

```bash
docker-compose up -d
```

---

## Security Features

* Role-Based Access Control (RBAC)
* Device Fingerprinting & IP Checks
* Google 2FA Authentication
* Suspicious Login Alerts
* Encrypted Data Backups

---

## Database Schema (Finance Example)

---
# MYSQL

---

## Roadmap

* [x] Core ERP Modules
* [x] Finance & Accounting
* [ ] AI Assistant for Smart Reporting
* [ ] Mobile App (React Native)
* [ ] Multi-language & Localization

---

## Contributing

Pull requests are welcome. Please fork the repo and submit your changes via PR.

---

## License

WorkZenix is licensed under the **MIT License**.

---

## Contact

For support or inquiries: **[support@workzenix.com](mailto:support@workzenix.com)**

---

## Auther
Name: MD ASRAFUZZAMAN 
Mobile: 01314924003
Email: **[asrafuzzaman705@gamil.com](mailto:asrafuzzaman705@gamil.com)**
