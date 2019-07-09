export default ({ authGuard, guestGuard }) => [
  { path: '/', name: 'welcome', component: require('~/pages/welcome.vue') },

  // Authenticated routes.
  ...authGuard([
    { path: '/home', name: 'home', component: require('~/pages/home.vue') },
    { path: '/dashboard', name: 'dashboard', component: require('~/pages/dashboard.vue') },
    { path: '/calendar', name: 'calendar', component: require('~/pages/calendar.vue') },
    { path: '/services', name: 'services', component: require('~/pages/services.vue') },
    { path: '/reports', name: 'reports', component: require('~/pages/reports.vue') },
    {
      path: '/user',
      component: require('~/pages/user/index.vue'),
      children: [
        { path: '/client', name: 'user.client', component: require('~/pages/user/client.vue') },
        { path: '/employee', name: 'user.employee', component: require('~/pages/user/employee.vue') }
      ]
    },
    {
      path: '/company',
      component: require('~/pages/company/index.vue'),
      children: [
        { path: '', redirect: { name: 'company.detail' } },
        { path: '/detial', name: 'company.detail', component: require('~/pages/company/detail.vue') },
        { path: '/workinghour', name: 'company.workinghour', component: require('~/pages/company/workinghour.vue') }
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
