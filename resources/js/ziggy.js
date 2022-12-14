const Ziggy = {
    url: "http://127.0.0.1:8000",
    port: null,
    defaults: {},
    routes: {
        "parent.update-student_api": {
            uri: "api/parent/update-student",
            methods: ["POST"],
        },
        "parent.students_api": {
            uri: "api/parent/{user_id}/students",
            methods: ["GET", "HEAD"],
        },
        "parent.student_api": {
            uri: "api/parent/student/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.week-spending_api": {
            uri: "api/parent/{student_id}/week-spending",
            methods: ["GET", "HEAD"],
        },
        "parent.month-spending_api": {
            uri: "api/parent/{student_id}/month-spending",
            methods: ["GET", "HEAD"],
        },
        "parent.last-transactions_api": {
            uri: "api/parent/{student_id}/last-transactions",
            methods: ["GET", "HEAD"],
        },
        "parent.transactions_api": {
            uri: "api/parent/{student_id}/transactions",
            methods: ["GET", "HEAD"],
        },
        "parent.available-lunches_api": {
            uri: "api/parent/available-lunches",
            methods: ["GET", "HEAD"],
        },
        "admin.students_api": {
            uri: "api/admin/students",
            methods: ["GET", "HEAD"],
        },
        "admin.schools-invites_api": {
            uri: "api/admin/schools-for-invites",
            methods: ["GET", "HEAD"],
        },
        "admin.schools-index_api": {
            uri: "api/admin/schools",
            methods: ["GET", "HEAD"],
        },
        "admin.school-show_api": {
            uri: "api/admin/school/{school_id}",
            methods: ["GET", "HEAD"],
        },
        "admin.school-update_api": {
            uri: "api/admin/school",
            methods: ["PUT"],
        },
        "admin.merchants-index_api": {
            uri: "api/admin/school/{school_id}/merchants",
            methods: ["GET", "HEAD"],
        },
        "admin.merchant-show_api": {
            uri: "api/admin/merchant/{merchant_id}",
            methods: ["GET", "HEAD"],
        },
        "admin.merchant-update_api": {
            uri: "api/admin/merchant",
            methods: ["PUT"],
        },
        "admin.merchant-update-status_api": {
            uri: "api/admin/merchant-status",
            methods: ["PUT"],
        },
        "admin.invites_api": {
            uri: "api/admin/invites",
            methods: ["GET", "HEAD"],
        },
        "admin_invites.invite-emails_api": {
            uri: "api/admin/invite-emails",
            methods: ["GET", "HEAD"],
        },
        "admin_invites.user-emails_api": {
            uri: "api/admin/user-emails",
            methods: ["GET", "HEAD"],
        },
        "admin_send-invite_api": {
            uri: "api/admin/{schoolId}/send-invite",
            methods: ["POST"],
        },
        "school.dashboard-students": {
            uri: "api/school/{school_id}/dashboard-students",
            methods: ["GET", "HEAD"],
        },
        "school.students_api": {
            uri: "api/school/{school_id}/students",
            methods: ["GET", "HEAD"],
        },
        "school.last-transactions_api": {
            uri: "api/school/{school_id}/last-transactions",
            methods: ["GET", "HEAD"],
        },
        "school.transactions_api": {
            uri: "api/school/{school_id}/transactions",
            methods: ["GET", "HEAD"],
        },
        "school.invites_api": {
            uri: "api/school/{school_id}/invites",
            methods: ["GET", "HEAD"],
        },
        "school_invites.get-emails": {
            uri: "api/school/{school_id}/user-emails",
            methods: ["GET", "HEAD"],
        },
        "send.invite": { uri: "api/school/send-invite", methods: ["POST"] },
        "lunch.index": { uri: "api/school/lunch", methods: ["GET", "HEAD"] },
        "lunch.store": { uri: "api/school/lunch", methods: ["POST"] },
        "lunch.show": {
            uri: "api/school/lunch/{lunch}",
            methods: ["GET", "HEAD"],
            bindings: { lunch: "id" },
        },
        "lunch.update": {
            uri: "api/school/lunch/{lunch}",
            methods: ["PUT", "PATCH"],
            bindings: { lunch: "id" },
        },
        "lunch.destroy": {
            uri: "api/school/lunch/{lunch}",
            methods: ["DELETE"],
        },
        "setup.account": {
            uri: "setup-account/{uniqueID}",
            methods: ["GET", "HEAD"],
        },
        "setup.account_submit": {
            uri: "setup-account/{uniqueID}",
            methods: ["POST"],
        },
        "personal.form": {
            uri: "personal-form/{uniqueID}",
            methods: ["GET", "HEAD"],
        },
        "personal.form_submit": {
            uri: "personal-form/{uniqueID}",
            methods: ["POST"],
        },
        "verify.email": {
            uri: "verify-email/{uniqueID}",
            methods: ["GET", "HEAD"],
        },
        "verify.email_submit": {
            uri: "verify-email/{uniqueID}",
            methods: ["POST"],
        },
        default: { uri: "/", methods: ["GET", "HEAD"] },
        login: { uri: "login", methods: ["POST"] },
        "forgot.redirect": { uri: "mail-sent", methods: ["GET", "HEAD"] },
        "forgot.form": { uri: "forgot-password", methods: ["GET", "HEAD"] },
        "forgot.request": { uri: "forgot-password", methods: ["POST"] },
        "password.reset": {
            uri: "reset-password/{token}",
            methods: ["GET", "HEAD"],
        },
        "password.update": { uri: "reset-password", methods: ["POST"] },
        logout: { uri: "logout", methods: ["GET", "HEAD"] },
        "2fa.form": {
            uri: "two-factor-authentication",
            methods: ["GET", "HEAD"],
        },
        "2fa.submit": {
            uri: "submit-two-factor-authentication",
            methods: ["POST"],
        },
        "2fa.resend": {
            uri: "resend-two-factor-authentication",
            methods: ["POST"],
        },
        "admin.dashboard": { uri: "admin/dashboard", methods: ["GET", "HEAD"] },
        "admin.students": { uri: "admin/students", methods: ["GET", "HEAD"] },
        "admin.invite": { uri: "admin/invite", methods: ["GET", "HEAD"] },
        "admin.schools": { uri: "admin/schools", methods: ["GET", "HEAD"] },
        "admin.merchants": {
            uri: "admin/school/{school_id}/merchants",
            methods: ["GET", "HEAD"],
        },
        "parent.create-student": {
            uri: "parent/create-student/{user_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.create-student_submit": {
            uri: "parent/create-student/{user_id}",
            methods: ["POST"],
        },
        "parent.create-student-verify": {
            uri: "parent/create-student/verify/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.create-student-verify_submit": {
            uri: "parent/create-student-verify/{student_id}",
            methods: ["POST"],
        },
        "parents.dashboard": {
            uri: "parent/dashboard",
            methods: ["GET", "HEAD"],
        },
        "parent.two-fa": { uri: "parent/two-fa/{user_id}", methods: ["POST"] },
        "parent.update-password": {
            uri: "parent/update-password/{user_id}",
            methods: ["POST"],
        },
        "parent.settings_submit": {
            uri: "parent/settings/{student_id}",
            methods: ["POST"],
        },
        "parent.settings": {
            uri: "parent/settings/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.transactions": {
            uri: "parent/transactions/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.dashboard": {
            uri: "parent/dashboard/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "parent.available-lunches": {
            uri: "parent/available-lunches/{student_id}",
            methods: ["GET", "HEAD"],
        },
        "school.lunch-management": {
            uri: "school/lunch-management",
            methods: ["GET", "HEAD"],
        },
        "school.add-lunch": {
            uri: "school/add-lunch",
            methods: ["GET", "HEAD"],
        },
        "school.students": { uri: "school/students", methods: ["GET", "HEAD"] },
        "school.transactions": {
            uri: "school/transactions",
            methods: ["GET", "HEAD"],
        },
        "school.dashboard": {
            uri: "school/dashboard",
            methods: ["GET", "HEAD"],
        },
        "school.invite": { uri: "school/invite", methods: ["GET", "HEAD"] },
        "school.lunch-management-edit": {
            uri: "school/lunch-management/{lunch_id}/edit",
            methods: ["GET", "HEAD"],
        },
    },
};

if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
