"use client";

import { useEffect, useState } from 'react';

const Quiz = ({ quizId, userName }: { quizId: string; userName: string }) => {
  const [quizData, setQuizData] = useState<any>(null);
  const [currentQuestionIndex, setCurrentQuestionIndex] = useState(0);
  const [userAnswers, setUserAnswers] = useState<number[]>([]);
  const [submissionResult, setSubmissionResult] = useState<string | null>(null);

  useEffect(() => {
    const fetchQuiz = async () => {
      if (quizId) {
        try {
          const response = await fetch(`http://localhost:8081/api/tests/${quizId}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const data = await response.json();
          console.log('Fetched quiz data:', data);
          setQuizData(data);
        } catch (error) {
          console.error('Error fetching quiz data:', error);
        }
      }
    };

    fetchQuiz();
  }, [quizId]);

  const handleAnswerSelect = (answerId: number) => {
    const updatedAnswers = [...userAnswers];
    updatedAnswers[currentQuestionIndex] = answerId;
    setUserAnswers(updatedAnswers);
  };

  const handleNextQuestion = async () => {
    if (currentQuestionIndex < (quizData.questions.length - 1)) {
      setCurrentQuestionIndex(currentQuestionIndex + 1);
    } else {
      // Handle end of quiz (submit results)
      const correctAnswersCount = userAnswers.filter((answerId, index) => {
        return quizData.questions[index].answers.some(answer => answer.id === answerId && answer.is_correct);
      }).length;

      try {
        const response = await fetch('http://localhost:8081/api/user-tests', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            userName: userName,
            testId: quizId,
            score: correctAnswersCount,
          }),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        setSubmissionResult(`Paldies ${userName}, Tu atbildēji pareizi uz ${correctAnswersCount} no ${quizData.questions.length} jautājumiem.`);
      } catch (error) {
        console.error('Error submitting results:', error);
      }
    }
  };

  if (submissionResult) {
    return (
      <div className="flex flex-col items-center">
        <h2 className="text-2xl font-bold mb-4 text-black">{submissionResult}</h2>
      </div>
    );
  }

  if (!quizData) {
    return <div className="text-black">...</div>;
  }

  const currentQuestion = quizData.questions[currentQuestionIndex];

  const progressPercentage = ((currentQuestionIndex + 1) / quizData.questions.length) * 100;

  return (
    <div className="flex flex-col items-center">
      <h2 className="text-2xl font-bold mb-4 text-black">
        Jautājums {currentQuestionIndex + 1} no {quizData.questions.length}
      </h2>
      <p className="mb-4 text-black">{currentQuestion.text}</p>

      <div className="w-1/2 max-w-md bg-gray-300 rounded-full h-2 mb-4">
        <div
          className="bg-blue-500 h-2 rounded-full"
          style={{ width: `${progressPercentage}%` }}
        />
      </div>
      
      <div className="mb-4 w-full max-w-md" style={{ minHeight: '100px' }}>
        {currentQuestion.answers.map((answer: any) => (
          <label key={answer.id} className="flex items-center mb-2 text-black">
            <input
              type="radio"
              name={`question-${currentQuestion.id}`}
              value={answer.id}
              onChange={() => handleAnswerSelect(answer.id)}
              className="mr-2"
            />
            <span className="text-black">{answer.text}</span>
          </label>
        ))}
      </div>

      <button
        onClick={handleNextQuestion}
        disabled={userAnswers[currentQuestionIndex] === undefined}
        className={`bg-blue-500 text-white font-semibold rounded-lg py-2 px-4 ${
          userAnswers[currentQuestionIndex] === undefined ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600 transition duration-200'
        }`}
      >
        {currentQuestionIndex < (quizData.questions.length - 1) ? 'Next' : 'Submit'}
      </button>
    </div>
  );
};

export default Quiz;
