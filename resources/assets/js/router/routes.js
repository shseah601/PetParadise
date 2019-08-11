export default ({ employeeAuthGuard, authGuard, guestGuard }) => [
  { path: '/admin', redirect: { name: 'admin.home' } },

  // Authenticated routes for authenticated employees
  ...employeeAuthGuard([
    { path: '/admin/home', name: 'admin.home', component: require('~/pages/admin/home.vue') },
    { path: '/admin/dashboard', name: 'admin.dashboard', component: require('~/pages/admin/dashboard.vue') },
    { path: '/admin/calendar', name: 'admin.calendar', component: require('~/pages/admin/calendar.vue') },
    { path: '/admin/services', name: 'admin.services', component: require('~/pages/admin/services.vue') },
    { path: '/admin/reports', name: 'admin.reports', component: require('~/pages/admin/reports.vue') },
    { path: '/admin/pets', name: 'admin.pets', component: require('~/pages/admin/pets.vue') },
    { path: '/admin/users/clients', name: 'admin.users.clients', component: require('~/pages/admin/users/clients.vue') },
    { path: '/admin/users/employees', name: 'admin.users.employees', component: require('~/pages/admin/users/employees.vue') },
    { path: '/admin/company/detail', name: 'admin.company.detail', component: require('~/pages/admin/company/detail.vue') },
    { path: '/admin/company/workinghour', name: 'admin.company.workinghour', component: require('~/pages/admin/company/workinghour.vue') }

  ]),

  // Authenticated routes for authenticated users
  ...authGuard([
    { path: '/home', name: 'client.home', component: require('~/pages/client/home.vue') },
    { path: '/services', name: 'client.services', component: require('~/pages/client/services.vue') },
    { path: '/booking', name: 'client.booking', component: require('~/pages/client/booking.vue') },
    { path: '/bookings', name: 'client.bookings', component: require('~/pages/client/bookings.vue') },
    { path: '/pets', name: 'client.pets', component: require('~/pages/client/pets.vue') },
    {
      path: '/settings',
      component: require('~/pages/settings/index.vue'),
      children: [
        { path: '', redirect: { name: 'settings.profile' } },
        { path: 'profile', name: 'settings.profile', component: require('~/pages/settings/profile.vue') },
        { path: 'password', name: 'settings.password', component: require('~/pages/settings/password.vue') }
      ]
    }
  ]),

  // Guest routes.
  ...guestGuard([
    { path: '/login', name: 'login', component: require('~/pages/auth/login.vue') },
    { path: '/register', name: 'register', component: require('~/pages/auth/register.vue') },
    { path: '/password/reset', name: 'password.request', component: require('~/pages/auth/password/email.vue') },
    { path: '/password/reset/:token', name: 'password.reset', component: require('~/pages/auth/password/reset.vue') }
  ]),

  { path: '*', component: require('~/pages/errors/404.vue') }
]
