<template>
    <div>
        <account-calendar></account-calendar>
    </div>
</template>

<script>
import AccountCalendar from '../components/AccountCalendar'

export default {
    name: 'HouseholdPage',
    components: {
        'account-calendar' : AccountCalendar
    }
}
</script>

<style scoped>

</style>