export default ({ authGuard, guestGuard }) => [
  { path: '/admin', redirect: { name: 'admin.home' } },

  // Authenticated routes.
  ...authGuard([
    { path: '/admin/home', name: 'admin.home', component: require('~/pages/admin/home.vue') },
    { path: '/admin/dashboard', name: 'admin.dashboard', component: require('~/pages/admin/dashboard.vue') },
    { path: '/admin/calendar', name: 'admin.calendar', component: require('~/pages/admin/calendar.vue') },
    { path: '/admin/services', name: 'admin.services', component: require('~/pages/admin/services.vue') },
    { path: '/admin/reports', name: 'admin.reports', component: require('~/pages/admin/reports.vue') },
    { path: '/admin/users/clients', name: 'admin.users.clients', component: require('~/pages/admin/users/clients.vue') },
    { path: '/admin/users/employees', name: 'admin.users.employees', component: require('~/pages/admin/users/employees.vue') },

    { path: '/admin/company/detail', name: 'admin.company.detail', component: require('~/pages/admin/company/detail.vue') },
    { path: '/admin/company/workinghour', name: 'admin.company.workinghour', component: require('~/pages/admin/company/workinghour.vue') },

    {
      path: '/admin/settings',
      component: require('~/pages/admin/settings/index.vue'),
      children: [
        { path: '', redirect: { name: 'admin.settings.profile' } },
        { path: 'profile', name: 'admin.settings.profile', component: require('~/pages/admin/settings/profile.vue') },
        { path: 'password', name: 'admin.settings.password', component: require('~/pages/admin/settings/password.vue') }
      ]
    }
  ]),

  // Guest routes.
  ...guestGuard([
    { path: '/login', name: 'admin.login', component: require('~/pages/admin/auth/login.vue') },
    { path: '/admin/register', name: 'admin.register', component: require('~/pages/admin/auth/register.vue') },
    { path: '/admin/password/reset', name: 'admin.password.request', component: require('~/pages/admin/auth/password/email.vue') },
    { path: '/admin/password/reset/:token', name: 'admin.password.reset', component: require('~/pages/admin/auth/password/reset.vue') }
  ]),

  { path: '*', component: require('~/pages/errors/404.vue') }
]
