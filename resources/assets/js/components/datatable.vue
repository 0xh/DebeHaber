<template>

</template>

<script>


export default {

    data () {
        return {

        }
    },

    methods:
    {

    }
}
</script>



<style scoped>

.fa-times
{
    cursor: pointer;
}

i
{
    float: right;
    position: relative;
    opacity: 0.4;
}

ul
{
    position: absolute;
    padding: 0;
    min-width: 100%;
    background-color: #fff;
    list-style: none;
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0,0,0, 0.25);
    z-index: 1000;
}

li
{
    padding: 5px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
}

li:first-child
{
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

li:last-child
{
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom: 0;
}

span
{
    color: #2c3e50;
}

.active
{
    background-color: #3aa373;
}

.active span
{
    color: white;
}

.name
{
    font-weight: 500;
    font-size: 14px;
}

.screen-name
{
    font-style: italic;
}
</style>
