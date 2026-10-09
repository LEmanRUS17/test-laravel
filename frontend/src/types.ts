export type Gender = 'male' | 'female'

export interface User {
  id: number
  email: string
  gender: Gender
  created_at: string
  updated_at: string
}
