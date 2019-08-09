<template>
  <div>
    <v-toolbar flat>
      <v-list>
        <v-list-tile>
          <v-list-tile-title class="title">{{ name }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list>
      <v-list-tile :to="{ name: 'admin.home' }">
        <v-list-tile-action>
          <v-icon>home</v-icon>
        </v-list-tile-action>
        <v-list-tile-title>Home</v-list-tile-title>
      </v-list-tile>

      <v-list-tile v-for="(item, i) in items" :key="i" :to="item.route">
        <v-list-tile-action>
          <v-icon light v-html="item.icon"></v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title v-text="item.title"></v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>

      <v-list-group prepend-icon="account_circle">
        <template v-slot:activator>
          <v-list-tile>
            <v-list-tile-title>Users</v-list-tile-title>
          </v-list-tile>
        </template>
        <v-list-tile v-for="(user, i) in users" :key="i" :to="user.route">
          <v-list-tile-action>
            <v-icon light v-html="user.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="user.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>

      <v-list-group prepend-icon="business">
        <template v-slot:activator>
          <v-list-tile>
            <v-list-tile-title>Company</v-list-tile-title>
          </v-list-tile>
        </template>
        <v-list-tile v-for="(item, i) in company" :key="i" :to="item.route">
          <v-list-tile-action>
            <v-icon light v-html="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>
    </v-list>
  </div>
</template>

<script>
export default {
  data () {
    return {
      name: this.$t('nav_menu_title'),
      items: [
        {
          title: 'Dashboard',
          icon: 'dashboard',
          route: { name: 'admin.dashboard' }
        },
        {
          title: 'Account',
          icon: 'account_box',
          route: { name: 'settings.profile' }
        },
        {
          title: 'Calendar',
          icon: 'calendar_today',
          route: { name: 'admin.calendar' }
        },
        {
          title: 'Services',
          icon: 'room_service',
          route: { name: 'admin.services' }
        },
        {
          title: 'Reports',
          icon: 'assessment',
          route: { name: 'admin.reports' }
        },
        {
          title: 'Pets',
          icon: 'pets',
          route: { name: 'admin.pets' }
        }
      ],
      users: [
        {
          title: 'Client',
          icon: 'person',
          route: { name: 'admin.users.clients' }
        },
        {
          title: 'Employee',
          icon: 'person_outline',
          route: { name: 'admin.users.employees' }
        }
      ],
      company: [
        {
          title: 'Company Detail',
          icon: 'art_track',
          route: { name: 'admin.company.detail' }
        },
        {
          title: 'Working Hours',
          icon: 'access_time',
          route: { name: 'admin.company.workinghour' }
        }
      ]
    }
  }
}
</script>
