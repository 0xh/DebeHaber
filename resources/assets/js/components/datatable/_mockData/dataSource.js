import uniq from 'lodash/uniq'
import without from 'lodash/without'
import camelCase from 'lodash/camelCase'
const Random = require('mockjs').Random

const total = 120 // how many rows to generate
const getRandomUid = () => Random.integer(1, total)

const users = Array(total).fill().map((item, idx) => {
  let name = Random.name()
  return {
    uid: idx + 1,

    friends:0



  }
})

export default users
