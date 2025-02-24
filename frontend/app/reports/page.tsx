// /frontend/app/reports/page.tsx
"use client";

import { useEffect, useState } from 'react';

const ReportsPage = () => {
  const [reports, setReports] = useState([]);

  useEffect(() => {
    const fetchReports = async () => {
      try {
        const response = await fetch('http://localhost:8081/api/reports');

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        setReports(data);
      } catch (error) {
        console.error('Error fetching reports:', error);
      }
    };

    fetchReports();
  }, []);

  return (
    <div className="container mx-auto mt-10">
      <h1 className="text-3xl font-bold mb-6 text-black">Rezultāti</h1>
      <table className="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th className="border px-4 py-2 text-black">Vārds</th>
            <th className="border px-4 py-2 text-black">Testa nosaukums</th>
            <th className="border px-4 py-2 text-black">Pareizās atbildes</th>
          </tr>
        </thead>
        <tbody>
          {reports.map((report, index) => (
            <tr key={index}>
              <td className="border px-4 py-2 text-black">{report.user_name}</td>
              <td className="border px-4 py-2 text-black">{report.test_title}</td>
              <td className="border px-4 py-2 text-black">{report.score}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ReportsPage;
