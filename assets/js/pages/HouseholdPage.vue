<template>
    <div>
        <purchase-list></purchase-list>
        <account-calendar></account-calendar>
    </div>
</template>

<script>
import AccountCalendar from '../components/AccountCalendar';
import PurchaseForm from '../components/PurchaseForm';
import PurchaseList from '../components/PurchaseList';

export default {
    name: 'HouseholdPage',
    components: {
        'account-calendar' : AccountCalendar,
        'purchase-form': PurchaseForm,
        'purchase-list': PurchaseList
    }
}
</script>

<style scoped>

</style>