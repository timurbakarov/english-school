export default {
    props: ['schedules'],
    template: '<div><div v-for="schedule in schedules">{{ schedule.day + " " + schedule.hour + ":" + schedule.minutes }}</div></div>'
}
