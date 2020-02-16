<template>
    <div>
        <purchase-form></purchase-form>
        <account-calendar></account-calendar>
    </div>
</template>

<script>
import AccountCalendar from '../components/AccountCalendar'
import PurchaseForm from '../components/PurchaseForm'

export default {
    name: 'HouseholdPage',
    components: {
        'account-calendar' : AccountCalendar,
        'purchase-form': PurchaseForm
    }
}
</script>

<style scoped>

</style>