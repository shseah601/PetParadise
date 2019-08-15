export default ({ employeeAuthGuard, authGuard, guestGuard }) => [
  { path: '/admin', redirect: { name: 'admin.dashboard' } },

  // Authenticated routes for authenticated employees
  ...employeeAuthGuard([
    { path: '/admin/dashboard', name: 'admin.dashboard', component: require('~/pages/admin/dashboard.vue') },
    { path: '/admin/calendar', name: 'admin.calendar', component: require('~/pages/admin/calendar.vue') },
    { path: '/admin/services', name: 'admin.services', component: require('~/pages/admin/services.vue') },
    {
      path: '/admin/reports',
      component: require('~/pages/admin/reports/index.vue'),
      children: [
        { path: '', redirect: { name: 'admin.reports.bookings' } },
        { path: 'bookings', name: 'admin.reports.bookings', component: require('~/pages/admin/reports/booking.vue') },
        { path: 'pendingBookings', name: 'admin.reports.pendingBookings', component: require('~/pages/admin/reports/pending.vue') }
      ]
    },
    { path: '/admin/pets', name: 'admin.pets', component: require('~/pages/admin/pets.vue') },
    { path: '/admin/users/clients', name: 'admin.users.clients', component: require('~/pages/admin/users/clients.vue') },
    { path: '/admin/users/employees', name: 'admin.users.employees', component: require('~/pages/admin/users/employees.vue') },
    { path: '/admin/company/detail', name: 'admin.company.detail', component: require('~/pages/admin/company/detail.vue') },
    { path: '/admin/company/workinghour', name: 'admin.company.workinghour', component: require('~/pages/admin/company/workinghour.vue') }

  ]),

  // Authenticated routes for authenticated users
  ...authGuard([
    { path: '/home', name: 'client.home', component: require('~/pages/client/home.vue') },
    { path: '/book', name: 'client.book', component: require('~/pages/client/book.vue') },
    { path: '/pets', name: 'client.pets', component: require('~/pages/client/pets.vue') },
    {
      path: '/history',
      component: require('~/pages/client/history/index.vue'),
      children: [
        { path: '', redirect: { name: 'client.history.bookings' } },
        { path: 'bookings', name: 'client.history.bookings', component: require('~/pages/client/history/booking.vue') },
        { path: 'pendings', name: 'client.history.pendings', component: require('~/pages/client/history/pending.vue') }
      ]
    },
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
