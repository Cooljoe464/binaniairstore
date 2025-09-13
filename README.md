# Project Documentation: Airline Inventory Management System

---

### **1. Project Overview**

The Airline Inventory Management System is a comprehensive, web-based application designed to manage the entire lifecycle of aircraft parts, tools, and materials. Built on a modern and robust technical foundation, the system provides a centralized platform for store managers, technicians, and administrators to track inventory, manage stock levels, and ensure regulatory compliance with features like due date tracking.

The user interface is designed to be clean, intuitive, and fully responsive, providing a seamless experience on desktops, tablets, and mobile devices.

---

### **2. Core Features (What's Been Done)**

The system is organized into two main categories: **Management Modules** for core data administration and **Store Modules** for specialized inventory management.

#### **A. Management Modules**

These modules provide administrators with full control over the foundational data of the system.

*   **User Management:** Create, edit, and delete user accounts. Assign specific roles to users to control their access levels.
*   **Role & Permission Management:** A powerful interface to define user roles (e.g., Admin, Store Manager, Technician) and assign granular permissions to each role, ensuring users can only access the features relevant to their job.
*   **Aircraft Management:** Maintain a complete list of all aircraft in the fleet.
*   **Supplier Management:** Manage a directory of all parts and materials suppliers, including contact information.
*   **Shelf Location Management:** Define and manage all physical storage locations (e.g., rack numbers, shelf codes) within the warehouses.

#### **B. Store Modules**

Each store is a specialized module for managing a specific category of items, complete with tailored fields and business logic.

*   **Common Features:** All store modules include:
    *   **Live Search:** Instantly search for items by part number, serial number, or description.
    *   **Status Filtering:** Filter items by their current status (e.g., Serviceable, Unserviceable).
    *   **CSV Export:** Export the current view of the data to a CSV file for reporting or external use.
    *   **Responsive Design:** Tables automatically adapt to a card-based view on mobile devices for easy viewing on the go.

*   **Store Breakdown:**
    *   **Bonded Store:**
        *   **Rotables:** For high-value, repairable parts with unique serial numbers.
        *   **Consumables:** For expendable items, featuring visual alerts for items nearing their expiration date.
        *   **ESD Items:** For components sensitive to electrostatic discharge.
    *   **Dangerous Goods Store:** For hazardous materials, with tracking for expiration dates.
    *   **Tyre Store:** Specialized management for aircraft tyres.
    *   **Tool's Store:** Manage all company tools, with tracking for calibration and due dates.
    *   **Dope Store:** A dedicated store for dopes and chemical compounds.

#### **C. Key System-Wide Features**

*   **Dynamic Dashboard:** The main dashboard provides an at-a-glance overview of critical inventory metrics, including a count of all low-stock items and items nearing their due date. It also includes a personalized welcome message for the logged-in user.
*   **Automated Notifications:** The system automatically sends email and in-app notifications to designated managers for key events, such as low stock levels or approaching due dates, helping to prevent stockouts and compliance issues.
*   **Secure & Reliable:** The application is built with a focus on data integrity and security. All multi-step database operations are handled in a way that prevents data corruption, and the role-based access control ensures that sensitive data is protected.

---

### **3. Future Updates & Potential Enhancements**

The system is built on a flexible foundation that allows for many future improvements.

*   **Advanced Reporting & Analytics:**
    *   Develop a dedicated reporting module to generate and download PDF reports for audits, inventory valuation, and historical usage.
    *   Enhance the dashboard with graphical charts and customizable widgets to visualize key performance indicators (KPIs).
*   **Inventory & Audit Trail:**
    *   Implement a detailed history log for every item, tracking every status change, quantity update, and location transfer, including which user performed the action and when.
*   **Barcode & QR Code Integration:**
    *   Integrate barcode/QR code scanning capabilities to allow for rapid check-in, check-out, and stock-taking using mobile devices or dedicated scanners, reducing manual entry errors.
*   **Bulk Actions:**
    *   Add the ability for authorized users to edit or delete multiple items at once from the table views, improving efficiency for large-scale updates.
*   **External System Integration:**
    *   Connect the inventory system with accounting software for streamlined financial reporting.
    *   Integrate with supplier APIs to automate the purchase order process when stock levels fall below a certain threshold.
*   **User-Configurable Notifications:**
    *   Allow users to customize their notification preferences, choosing which alerts they receive and through which channels (e.g., email, SMS).
