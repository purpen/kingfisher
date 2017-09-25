// 公司证件类型certificate
const COMPANY_CERTIFICATE_TYPE = [
  {
    id: 1,
    name: '普通营业执照（存在独立的组织机构代码证）'
  },
  {
    id: 2,
    name: '多证合一营业执照（不含统一社会信用代码）'
  },
  {
    id: 3,
    name: '多证合一营业执照（含统一社会信用代码）'
  }
]

// 证件类型
const DOCUMENT_TYPE = [
  {
    id: 1,
    name: '身份证'
  },
  {
    id: 2,
    name: '港澳通行证'
  },
  {
    id: 3,
    name: '台胞证'
  },
  {
    id: 4,
    name: '护照'
  }

]

// test
const TEST = {}

module.exports = {
  COMPANY_CERTIFICATE_TYPE,
  DOCUMENT_TYPE,
  TEST
}
