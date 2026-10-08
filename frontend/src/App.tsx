import { useEffect, useState } from 'react';
import { fetchBikes, type Bike } from './services/api';

export default function App() {
  const [bikes, setBikes] = useState<Bike[]>([]);
  const [loading, setLoading] = useState<boolean>(true);

  useEffect(() => {
    fetchBikes()
      .then((data) => setBikes(data))
      .catch((err) => console.error(err))
      .finally(() => setLoading(false));
  }, []);

  return (
    <div className="min-h-screen bg-slate-50 text-slate-900">
      {/* Navbar */}
      <header className="border-b bg-white shadow-sm sticky top-0 z-10">
        <div className="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
          <div className="flex items-center gap-2">
            <span className="text-2xl font-black tracking-tight text-blue-600">RideEasy</span>
          </div>
          <nav className="flex items-center gap-6 text-sm font-medium text-slate-600">
            <a href="#bikes" className="hover:text-blue-600 transition-colors">Bikes</a>
            <a href="#about" className="hover:text-blue-600 transition-colors">How it works</a>
            <button className="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-sm">
              Sign In
            </button>
          </nav>
        </div>
      </header>

      {/* Hero Section */}
      <section className="max-w-6xl mx-auto px-4 py-12 text-center">
        <h1 className="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 mb-4">
          Rent Premium Bikes & Scooters
        </h1>
        <p className="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
          Seamless rentals powered by Express & Supabase. Choose your ride, book instantly, and explore.
        </p>
      </section>

      {/* Bike Catalog */}
      <main className="max-w-6xl mx-auto px-4 pb-16" id="bikes">
        <h2 className="text-2xl font-bold mb-6 text-slate-800">Available Vehicles</h2>
        {loading ? (
          <div className="flex justify-center items-center py-20 text-slate-500 font-medium">
            Loading vehicles...
          </div>
        ) : bikes.length === 0 ? (
          <div className="bg-white border border-dashed rounded-xl p-12 text-center text-slate-500">
            <p className="text-lg font-medium">No bikes found in the database.</p>
            <p className="text-sm text-slate-400 mt-1">Add items using Prisma Studio or via the Express API.</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {bikes.map((bike) => (
              <div key={bike.id} className="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div className="h-44 bg-slate-100 flex items-center justify-center text-slate-400 font-medium">
                  {bike.image ? (
                    <img src={bike.image} alt={bike.name} className="w-full h-full object-cover" />
                  ) : (
                    <span>No Image Available</span>
                  )}
                </div>
                <div className="p-5">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-xs font-semibold uppercase tracking-wider text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                      {bike.type}
                    </span>
                    <span className="text-xs text-slate-500 font-medium">{bike.size || 'Standard'}</span>
                  </div>
                  <h3 className="font-bold text-lg text-slate-900 mb-1">{bike.name}</h3>
                  <p className="text-sm text-slate-600 mb-4 line-clamp-2">{bike.description || 'Smooth and reliable ride.'}</p>
                  <div className="flex items-center justify-between pt-4 border-t border-slate-100">
                    <div>
                      <span className="text-2xl font-extrabold text-slate-900">${bike.pricePerDay}</span>
                      <span className="text-xs text-slate-500"> / day</span>
                    </div>
                    <button className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                      Book Now
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        )}
      </main>
    </div>
  );
}
