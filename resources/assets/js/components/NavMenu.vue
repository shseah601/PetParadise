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
      <v-list-tile :to="{ name: 'home' }">
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

      <v-list-group no-action>
        <v-list-tile slot="activator">
          <v-list-tile-action>
            <v-icon light>account_circle</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Users</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile v-for="(user, i) in users" :key="i" :to="user.route">
          <v-list-tile-action>
            <v-icon light v-html="user.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="user.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>
      <v-list-group no-action>
        <v-list-tile slot="activator">
          <v-list-tile-action>
            <v-icon light>business</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>Company</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>

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
          route: { name: 'dashboard' }
        },
        {
          title: 'Account',
          icon: 'account_box',
          route: { name: 'settings.profile' }
        },
        {
          title: 'Calendar',
          icon: 'calendar_today',
          route: { name: 'calendar' }
        },
        {
          title: 'Services',
          icon: 'room_service',
          route: { name: 'services' }
        },
        {
          title: 'Reports',
          icon: 'assessment',
          route: { name: 'reports' }
        }
      ],
      users: [
        {
          title: 'Client',
          icon: 'person',
          route: { name: 'user.client' }
        },
        {
          title: 'Employee',
          icon: 'person_outline',
          route: { name: 'user.employee' }
        }
      ],
      company: [
        {
          title: 'Company Detail',
          icon: 'art_track',
          route: { name: 'company.detail' }
        },
        {
          title: 'Working Hours',
          icon: 'access_time',
          route: { name: 'company.workinghour' }
        }
      ]
    }
  }
}
</script>
