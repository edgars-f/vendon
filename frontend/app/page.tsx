"use client";

import { useEffect, useState } from 'react';
import Quiz from './Quiz'; // Import the Quiz component
import { useRouter } from 'next/navigation'; // Use Next.js router for navigation

const HomePage = () => {
  const [userName, setUserName] = useState('');
  const [tests, setTests] = useState<{ id: string; title: string }[]>([]);
  const [selectedTest, setSelectedTest] = useState('');
  const [isQuizStarted, setIsQuizStarted] = useState(false);
  const router = useRouter(); // Initialize the router

  useEffect(() => {
    const fetchTests = async () => {
      try {
        const response = await fetch('http://localhost:8081/api/tests');

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        setTests(data);
      } catch (error) {
        console.error('Error fetching tests:', error);
      }
    };

    fetchTests();
  }, []);

  const handleStart = () => {
    setIsQuizStarted(true); // Start the quiz
  };

  const handleViewReports = () => {
    router.push('/reports'); // Navigate to the reports page
  };

  return (
    <div className="flex flex-col items-center mt-16">
      <h1 className="text-3xl font-bold mb-6 text-black">Testa uzdevums</h1>
      {!isQuizStarted ? (
        <>
          <input
            type="text"
            placeholder="Ievadi savu vārdu"
            value={userName}
            onChange={(e) => setUserName(e.target.value)}
            className="border border-gray-300 rounded-lg p-2 mb-4 w-1/2 text-black"
          />
          <select
            value={selectedTest}
            onChange={(e) => setSelectedTest(e.target.value)}
            className="border border-gray-300 rounded-lg p-2 mb-4 w-1/2 text-black"
          >
            <option value="">Izvēlies testu</option>
            {tests.map((test) => (
              <option key={test.id} value={test.id}>
                {test.title}
              </option>
            ))}
          </select>
          <button
            onClick={handleStart}
            disabled={!userName || !selectedTest} // Disable button if no username or test is selected
            className={`bg-blue-500 text-white font-semibold rounded-lg py-2 px-4 hover:bg-blue-600 transition duration-200 ${(!userName || !selectedTest) ? 'opacity-50 cursor-not-allowed' : ''}`}
          >
            Sākt
          </button>
          <button
            onClick={handleViewReports}
            className="bg-green-500 absolute top-5 right-5 text-white font-semibold rounded-lg py-2 px-4 hover:bg-green-600 transition duration-200 mt-4"
          >
            Visi rezultāti
          </button>
        </>
      ) : (
        <Quiz quizId={selectedTest} userName={userName} />
      )}
    </div>
  );
};

export default HomePage;
