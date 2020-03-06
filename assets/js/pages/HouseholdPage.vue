<template>
    <div>
        <category-form></category-form>
        <purchase-list></purchase-list>
        <account-calendar></account-calendar>
    </div>
</template>

<script>
import AccountCalendar from '../components/AccountCalendar';
import PurchaseForm from '../components/PurchaseForm';
import PurchaseList from '../components/PurchaseList';
import CategoryForm from '../components/CategoryForm';

export default {
    name: 'HouseholdPage',
    components: {
        'account-calendar' : AccountCalendar,
        'purchase-form': PurchaseForm,
        'purchase-list': PurchaseList,
        'category-form': CategoryForm,
    }
}
</script>

<style scoped>

</style>