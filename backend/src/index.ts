import express, { Request, Response } from 'express';
import cors from 'cors';
import dotenv from 'dotenv';
import { prisma } from './lib/prisma.js';

dotenv.config();

const app = express();
const PORT = process.env.PORT || 5000;

app.use(cors());
app.use(express.json());

// Health check
app.get('/api/health', (_req: Request, res: Response) => {
  res.json({ status: 'ok', service: 'RideEasy API' });
});

// Bikes endpoints
app.get('/api/bikes', async (_req: Request, res: Response) => {
  try {
    const bikes = await prisma.bike.findMany({
      orderBy: { createdAt: 'desc' },
    });
    res.json(bikes);
  } catch (error) {
    res.status(500).json({ error: 'Failed to fetch bikes' });
  }
});

// Bookings endpoint (links to userId and bikeId as UUID)
app.post('/api/bookings', async (req: Request, res: Response) => {
  try {
    const { bikeId, userId, days, totalAmount, paymentMethod, startDate, endDate } = req.body;
    const booking = await prisma.booking.create({
      data: {
        bikeId,
        userId,
        days: Number(days),
        totalAmount,
        paymentMethod,
        startDate: startDate ? new Date(startDate) : undefined,
        endDate: endDate ? new Date(endDate) : undefined,
      },
      include: {
        bike: true,
        user: { select: { id: true, name: true, email: true, contactNumber: true } },
      },
    });
    res.status(201).json(booking);
  } catch (error) {
    res.status(500).json({ error: 'Failed to create booking' });
  }
});

// Users listing (excluding password)
app.get('/api/users', async (_req: Request, res: Response) => {
  try {
    const users = await prisma.user.findMany({
      where: { isArchive: false },
      select: {
        id: true,
        name: true,
        email: true,
        contactNumber: true,
        role: true,
        isActive: true,
        createdAt: true,
      },
    });
    res.json(users);
  } catch (error) {
    res.status(500).json({ error: 'Failed to fetch users' });
  }
});

app.listen(PORT, () => {
  console.log(`RideEasy Express server running on port ${PORT}`);
});
