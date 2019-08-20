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
      <template v-if="role.name == 'admin' || role.name == 'employee'">
        <v-list-tile v-for="(item, i) in adminItems" :key="i" :to="item.route">
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
              <v-list-tile-title>User Management</v-list-tile-title>
            </v-list-tile>
          </template>
          <template v-for="(user, i) in adminItems2" >
            <v-list-tile v-if="user.title != 'Employee' || role.name == 'admin'" :key="i" :to="user.route">
              <v-list-tile-action>
                <v-icon light v-html="user.icon"></v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title v-text="user.title"></v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
        </v-list-group>

        <v-list-group v-if="role.name =='admin'" prepend-icon="business">
          <template v-slot:activator>
            <v-list-tile>
              <v-list-tile-title>Company</v-list-tile-title>
            </v-list-tile>
          </template>
          <v-list-tile v-for="(item, i) in adminItems3" :key="i" :to="item.route">
            <v-list-tile-action>
              <v-icon light v-html="item.icon"></v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title"></v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list-group>
      </template>

      <template v-else>
        <v-list-tile :to="{ name: 'client.home' }">
          <v-list-tile-action>
            <v-icon>home</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>Home</v-list-tile-title>
        </v-list-tile>

        <v-list-tile v-for="(item, i) in clientItems" :key="i" :to="item.route">
          <v-list-tile-action>
            <v-icon light v-html="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </template>
      <v-list-tile :to="{ name: 'settings.profile' }">
        <v-list-tile-action>
          <v-icon>account_box</v-icon>
        </v-list-tile-action>
        <v-list-tile-title>Account</v-list-tile-title>
      </v-list-tile>
    </v-list>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      name: this.$t('nav_menu_title'),
      adminItems: [
        {
          title: 'Dashboard',
          icon: 'dashboard',
          route: { name: 'admin.dashboard' }
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
          title: 'Bookings',
          icon: 'assessment',
          route: { name: 'admin.reports.bookings' }
        },
        {
          title: 'Pets',
          icon: 'pets',
          route: { name: 'admin.pets' }
        }
      ],
      adminItems2: [
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
      adminItems3: [
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
      ],
      clientItems: [
        {
          title: 'Bookings',
          icon: 'event',
          route: { name: 'client.history.bookings' }
        },
        {
          title: 'Pets',
          icon: 'pets',
          route: { name: 'client.pets' }
        }
      ]
    }
  },
  computed: {
    ...mapGetters({
      role: 'authRole',
      detail: 'authDetail',
      authenticated: 'authCheck'
    })
  }
}
</script>
