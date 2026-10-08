import axios from 'axios';

export const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:5000/api',
});

export interface Bike {
  id: string; // UUID
  name: string;
  type: string;
  description?: string;
  gears?: number;
  size?: string;
  pricePerDay: string;
  image?: string;
  status: 'AVAILABLE' | 'RENTED' | 'MAINTENANCE';
}

export const fetchBikes = async (): Promise<Bike[]> => {
  const response = await api.get<Bike[]>('/bikes');
  return response.data;
};
