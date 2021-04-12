<template>
  <Page>
    <b-alert variant="warning" :show="!loader || (!loader.isActive && !cart)">
      You have no items in your shopping cart!
    </b-alert>
    <div v-if="cart"
         class="p-3 border rounded">
      <b-table
          :items="cart.items"
          :fields="fields"
          :responsive="true"
      >
        <template #table-busy>
          <div class="text-center">
            <b-spinner class="align-middle" variant="primary"></b-spinner>
          </div>
        </template>
        <template #cell(product)="data">
          {{ data.item.productName }}
        </template>
        <template #cell(quantity)="data">
          <b-form-select
              class="w-auto"
              :options="quantityOptions"
              v-model="data.item.quantity"
              size="sm"
              @change="changeQuantity(data.item.id)"
          ></b-form-select>
        </template>
        <template #cell(price)="data">
          {{ data.item.price|currency }}
        </template>
        <template #cell(total)="data">
          {{ (data.item.price * data.item.quantity)|currency }}
        </template>
        <template #cell(actions)="data">
          <b-button size="sm" variant="outline-danger" @click="remove(data.item.id)">
            <b-icon-trash></b-icon-trash>
          </b-button>
        </template>
        <template #table-caption>
          <div class="text-right">
            <strong>Total amount: </strong>
            <span>{{ cart.amount|currency }}</span>
          </div>
        </template>
      </b-table>
    </div>
  </Page>
</template>
<script src="./index.js"></script>
<style src="./index.scss" lang="scss" scoped></style>